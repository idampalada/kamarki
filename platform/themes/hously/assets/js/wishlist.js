import {clearCookies, getCookie, setCookie} from './utils'

class Wishlist {
    constructor() {
        this.refresh()

        $(document).on('click', '.add-to-wishlist', (e) => {
            e.preventDefault()

            this.addOrRemove($(e.currentTarget))
        })
    }

    addOrRemove($element) {
        const cookieName = 'real_estate_wishlist'
        const id = $element.data('id')
        const type = $element.data('type')
        let wishlist = decodeURIComponent(getCookie(cookieName))
        if (!wishlist) {
            wishlist = {
                projects: [],
                properties: [],
            }
        } else {
            wishlist = JSON.parse(wishlist)
        }

        if (id != null && id !== 0 && id !== undefined) {
            let currentWishlist = wishlist.properties
            if (type === 'project') {
                currentWishlist = wishlist.projects
            }

            const index = currentWishlist.map(function (value) {
                return value
            }).indexOf(id)

            if (index === -1) {
                if (type === 'project') {
                    wishlist.projects.push(id)
                } else {
                    wishlist.properties.push(id)
                }
                clearCookies(cookieName)
                setCookie(cookieName, JSON.stringify(wishlist), 60)
                $element.find('i').removeClass('mdi mdi-heart-outline').addClass('mdi mdi-heart')
            } else {
                if (type === 'project') {
                    wishlist.projects.splice(index, 1)
                } else {
                    wishlist.properties.splice(index, 1)
                }
                clearCookies(cookieName)
                setCookie(cookieName, JSON.stringify(wishlist), 60)
                $element.find('i').removeClass('mdi mdi-heart').addClass('mdi mdi-heart-outline')
            }
        }

        const cookieValues = JSON.parse(getCookie(cookieName))

        const countWishlist = cookieValues.properties.length + cookieValues.projects.length

        $('.wishlist-count').text(countWishlist)
        this.refresh()
    }

    refresh() {
        const cookieName = 'real_estate_wishlist'
        const wishListCookies = decodeURIComponent(getCookie(cookieName))

        if (wishListCookies !== null && wishListCookies !== undefined && !!wishListCookies) {
            const wishlist = JSON.parse(wishListCookies)

            if (wishlist.properties.length) {
                $.each($(document).find(`.add-to-wishlist[data-box-type="property"]`), function (key, element) {
                    const id = $(element).data('id')
                    if (wishlist.properties.indexOf(id) !== -1) {
                        $(element).find('i').removeClass('mdi mdi-heart-outline').addClass('mdi mdi-heart')
                    }
                })
            }

            if (wishlist.projects.length) {
                $.each($(document).find(`.add-to-wishlist[data-box-type="project"]`), function (key, element) {
                    const id = $(element).data('id')
                    if (wishlist.projects.indexOf(id) !== -1) {
                        $(element).find('i').removeClass('mdi mdi-heart-outline').addClass('mdi mdi-heart')
                    }
                })
            }
        }
    }
}

export default Wishlist

new Wishlist()
