import Wishlist from './wishlist'

class ItemFilter {
    $itemElement = $('.item-search')

    $filterDrawer = $('#filter-drawer')

    wishlist = new Wishlist()

    searchParams = new URLSearchParams(window.location.search)

    form = this.$itemElement.find('form')

    action = this.form.prop('action')

    ajaxUrl = this.form.data('ajax-url')

    url = this.searchParams.toString() === '' ? this.action : `${this.action}?${this.searchParams.toString()}`

    ajaxUrlWithQueryString = this.searchParams.toString() === '' ? this.ajaxUrl : `${this.ajaxUrl}?${this.searchParams.toString()}`

    constructor() {
        $(document).on('click', '.sidebar-backdrop', (e) => {
            if(!$(e.currentTarget).is('#filter-drawer > div')) {
                this.closeFilterDrawer()
            }
        })

        this.form.on('submit', (e) => {
            e.preventDefault()
            const data = $(e.currentTarget).serializeArray()
            data.forEach((item) => {
                if (! item.value) {
                    this.searchParams.delete(item.name)
                    return
                }

                if (item.name === 'keyword') {
                    this.searchParams.set('k', item.value)
                    return
                }

                this.searchParams.set(item.name, item.value)
            })

            this.closeFilterDrawer()
            this.refresh()
        })
        this.$filterDrawer
            .on('click', '#close-filters', () => {
                this.closeFilterDrawer()
            })

        this.$itemElement
            .on('change', '#sort-by', () => {
                const value = this.$itemElement.find('#sort-by').val()
                this.searchParams.set('sort_by', value)
                this.refresh()
            })
            .on('change', '#per-page', () => {
                const value = this.$itemElement.find('#per-page').val()
                this.searchParams.set('per_page', value)
                this.refresh()
            })
            .on('click', '.reset-filter', (e) => {
                e.preventDefault()
                this.closeFilterDrawer()

                this.searchParams = new URLSearchParams()
                this.$itemElement.not(':has(> input[name="type"])') .find('input').val('')
                this.$itemElement.find('select').prop('selectedIndex', 0)
                this.refresh()
            })
            .on('click', '#open-filter', () => {
                this.openFilterDrawer()
            })
            .on('click', '.toggle-layout', (e) => {
                this.searchParams.set('layout', $(e.currentTarget).data('type'))
                $('.toggle-layout').removeClass('bg-secondary').addClass('bg-slate-500').prop('disabled', false)
                $(e.currentTarget).addClass('bg-secondary').removeClass('bg-slate-500').prop('disabled', true)
                this.refresh()
            })

        $(document).on('click', '#pagination a', (e) => {
            e.preventDefault()
            const url = new URL(e.target.href)

            this.searchParams.set('page', url.searchParams.get('page'))
            this.refresh()
        })
    }

    refresh() {
        const $itemsList = $(document).find('#items-list')
        const type = $itemsList.data('type')
        const layout = this.searchParams.get('layout') || $itemsList.data('layout')
        const skeleton = $(`#${type}-${layout}-skeleton`).html()

        if (layout === 'grid') {
            $itemsList.children().removeClass('lg:grid-cols-2').addClass('md:grid-cols-2 lg:grid-cols-3')
            this.disableMap()
        } else if (layout === 'list') {
            $itemsList.children().removeClass('md:grid-cols-2 lg:grid-cols-3').addClass('lg:grid-cols-2')
            this.disableMap()
        } else if (layout === 'map') {
            this.activeMap()
            this.initMap()
        }
        if (skeleton) {
            $itemsList.find(`.${type}-item`).each((index, element) => {
                $(element).html(skeleton)
            })
        }

        const categoryId = this.$itemElement.find('input[name="category_id"]')

        if (categoryId.length) {
            this.searchParams.set('category_id', categoryId.val())
        }

        let timeout = null

        clearTimeout(timeout)

        $('html, body').animate({
            scrollTop: $('#items-list').offset().top - 200
        }, 0)

        $itemsList.addClass('animate-pulse')

        this.updateBrowserUrl()
        timeout = setTimeout(() => {
            $.post(this.ajaxUrlWithQueryString, (response) => {
                $itemsList.html(response.data)
                this.wishlist.refresh()
                if (layout === 'map') {
                    this.activeMap()
                    this.initMap()
                }
                $itemsList.removeClass('animate-pulse')
            })
        }, 500)
    }

    updateBrowserUrl() {
        this.url = this.searchParams.toString() === '' ? this.action : `${this.action}?${this.searchParams.toString()}`
        this.ajaxUrlWithQueryString = this.searchParams.toString() === '' ? this.ajaxUrl : `${this.ajaxUrl}?${this.searchParams.toString()}`
        window.history.pushState({}, '', this.url)
    }

    openFilterDrawer() {
        this.$filterDrawer.removeClass('-translate-x-full')
        $(document).find('.sidebar-backdrop').removeClass('hidden')
    }

    closeFilterDrawer() {
        this.$filterDrawer.addClass('-translate-x-full')
        $(document).find('.sidebar-backdrop').addClass('hidden')
    }

    initMap() {
        const $map = $('#map')
        const $viewTypMap = $('.view-type-map')
        if (!$map.length) {
            return
        }
        if ($viewTypMap.length && !$viewTypMap.hasClass('active')) {
            return
        }

        let totalPage = 0
        let currentPage = 1
        let center = $map.data('center')
        const params = this.searchToObject()
        const centerFirst = $('#items-map .projects-item[data-lat][data-long]').filter(function () {
            return $(this).data('lat') && $(this).data('long')
        })

        if (centerFirst && centerFirst.length) {
            center = [centerFirst.data('lat'), centerFirst.data('long')]
        }

        if (window.activeMap) {
            window.activeMap.off()
            window.activeMap.remove()
        }

        const map = L.map('map', {
            zoomControl: true,
            scrollWheelZoom: true,
            dragging: true,
            maxZoom: $map.data('max-zoom') || 22
        }).setView(center, 14)

        L.tileLayer($map.data('tile-layer') ? $map.data('tile-layer') : 'https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}').addTo(map)

        const markers = new L.MarkerClusterGroup()
        let markersList = []
        const $templatePopup = $('#traffic-popup-map-template').html()

        const populate = () => {
            if ((totalPage === 0) || currentPage <= totalPage) {
                params.page = currentPage
                $.ajax({
                    url: $map.data('url'),
                    type: 'GET',
                    data: params,
                    success: (res) => {
                        if (res.data.length < 1) {
                            return
                        }

                        res.data.forEach(house => {
                            if (house.latitude && house.longitude) {
                                const myIcon = L.divIcon({
                                    className: 'boxmarker',
                                    iconSize: L.point(50, 20),
                                    html: house.map_icon
                                })
                                const popup = this.templateReplace(house, $templatePopup)
                                const m = new L.Marker(new L.LatLng(house.latitude, house.longitude), {icon: myIcon})
                                    .bindPopup(popup)
                                    .addTo(map)
                                markersList.push(m)
                                markers.addLayer(m)

                                map.flyToBounds(L.latLngBounds(markersList.map(marker => marker.getLatLng())))
                            }
                        })
                        if (totalPage === 0) {
                            totalPage = res.meta.last_page
                        }
                        currentPage++
                        populate()
                    }
                })
            }

            return
        }

        populate()
        map.addLayer(markers)

        window.activeMap = map
    }

    searchToObject() {
        let pairs = window.location.search.substring(1).split('&'),
            obj = {},
            pair,
            i

        for (i in pairs) {
            if (pairs[i] === '') continue

            pair = pairs[i].split('=')
            obj[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1])
        }

        return obj
    }

    templateReplace(data, template) {
        const keys = Object.keys(data)
        for (const i in keys) {
            if (keys.hasOwnProperty(i)) {
                const key = keys[i]
                template = template.replace(new RegExp('__' + key + '__', 'gi'), data[key] || '')
            }
        }
        return template
    }

    activeMap() {
        $('html, body').animate({
            scrollTop: $('#items-map').offset().top - 230
        }, 0)

        $('#items-list').addClass('hidden')
        $('#items-map').removeClass('hidden')
    }

    disableMap() {
        $('#items-map').addClass('hidden')
        $('#items-list').removeClass('hidden')
    }
}

new ItemFilter()
