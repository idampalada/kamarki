$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

window.__ = (key) => {
    window.trans = window.trans || {};

    return window.trans[key] !== 'undefined' && window.trans[key] ? window.trans[key] : key;
}

$(document).ready(function () {
    if ((typeof easy_background) !== "undefined") {
        easy_background("#home", {
            slide: $('#home').data('images'),
            delay: [4000, 4000, 4000]
        })
    }

    new SearchFilter().init()
})

class SearchFilter {
    init() {
        this.keyword()
        this.location()
        this.project()

        $('.search-filter').on('click', '.toggle-advanced-search', function () {
            $(this).siblings('.advanced-search').toggleClass('hidden')
        })

        $('#searchTab').on('click', 'button', function () {
            const searchFilterBox = $(this).parents('#searchTab').siblings('.search-filter')
            searchFilterBox.find('.advanced-search').addClass('hidden')
        })

        $('body').on('click', function (e){
            if(!$(e.target).is('#location-suggestion')) {
                $('#location-suggestion').find('ul').html(null)
            }
            if(!$(e.target).is('#keyword-suggestion')) {
                $('#keyword-suggestion').find('ul').html(null)
            }
        })
    }

    keyword() {
        let timeout = null

        $('.search-filter')
            .on('keyup', 'input[name="k"]', function () {
                const $currentTarget = $(this).closest('form')
                const $searchForm = $currentTarget.find('input[name="k"]').parent()

                $searchForm.find('.mdi-loading').removeClass('hidden')

                timeout = setTimeout(() => {
                    const keyword = $currentTarget.find('input[name="k"]').val()
                    const type = $currentTarget.find('input[name="type"]').val()

                    const searchParams = new URLSearchParams();
                    searchParams.append('type', type)
                    searchParams.append('k', keyword)
                    searchParams.append('minimal', true)

                    const url = `${$currentTarget.data('ajax-url')}?${searchParams.toString()}`

                    $.post(url, (response) => {
                        $searchForm.find('.mdi-loading').addClass('hidden')
                        $searchForm.append(response.data)
                        $searchForm.find('#keyword-suggestion').removeClass('hidden')
                    })
                }, 500)
            })
            .on('keydown', 'input[name="k"]', function () {
                $('.search-filter').find('#keyword-suggestion').remove()
            })
    }

    location() {
        let timeout = null

        $('.search-filter')
            .on('keyup', 'input[name="location"]', function () {
                const $currentTarget = $(this)

                $currentTarget.siblings('.mdi-loading').removeClass('hidden')

                clearTimeout(timeout)

                timeout = setTimeout(() => {
                    const value = $currentTarget.val()
                    const url = `${$currentTarget.data('url')}?location=${value}`
                    $.get(url, (response) => {
                        $currentTarget.siblings('.mdi-loading').addClass('hidden')
                        const $searchForm = $currentTarget.closest('.filter-search-form')
                        $searchForm.append(response.data)
                        $searchForm.find('#location-suggestion').removeClass('hidden')
                    })
                }, 500)
            })
            .on('keydown', 'input[name="location"]', function () {
                $('.search-filter').find('#location-suggestion').remove()
            })
            .on('click', '#location-suggestion ul li', function () {
                $(this).closest('.filter-search-form').find('input[name="location"]').val($(this).data('location'))
                $('.search-filter').find('#location-suggestion ul').remove()
            })
    }

    project() {
        let timeout = null

        $('.search-filter')
            .on('keyup', 'input[name="project"]', function () {
                const $currentTarget = $(this)

                $currentTarget.siblings('.mdi-loading').removeClass('hidden')

                clearTimeout(timeout)

                timeout = setTimeout(() => {
                    const value = $currentTarget.val()
                    const url = `${$currentTarget.data('url')}?project=${value}`
                    $.get(url, (response) => {
                        $currentTarget.siblings('.mdi-loading').addClass('hidden')
                        const $searchForm = $currentTarget.closest('.filter-search-form')
                        $searchForm.append(response.data)
                        $searchForm.find('#projects-suggestion').removeClass('hidden')
                    })
                }, 500)
            })
            .on('keydown', 'input[name="project"]', function () {
                $('.search-filter').find('#projects-suggestion').remove()
            })
            .on('click', '#projects-suggestion ul li', function () {
                $(this).closest('.filter-search-form').find('input[name="project"]').val($(this).data('project'))
                $('.search-filter').find('#projects-suggestion ul').remove()
            })
    }
}
