import { clearCookies, getCookie, handleError, setCookie, showError, showSuccess } from './utils'

window.addEventListener('load', fn, false)

function fn() {
    if (document.getElementById('preloader')) {
        setTimeout(() => {
            document.getElementById('preloader').style.visibility = 'hidden'
            document.getElementById('preloader').style.opacity = '0'
        }, 350)
    }
    activateMenu()
}

window.toggleMenu = () => {
    document.getElementById('isToggle').classList.toggle('open')
    let isOpen = document.getElementById('navigation')
    if (isOpen.style.display === 'block') {
        isOpen.style.display = 'none'
    } else {
        isOpen.style.display = 'block'
    }
}

window.topFunction = () => {
    document.body.scrollTop = 0
    document.documentElement.scrollTop = 0
}

function getClosest(elem, selector) {
    if (!Element.prototype.matches) {
        Element.prototype.matches =
            Element.prototype.matchesSelector ||
            Element.prototype.mozMatchesSelector ||
            Element.prototype.msMatchesSelector ||
            Element.prototype.oMatchesSelector ||
            Element.prototype.webkitMatchesSelector ||
            function (s) {
                let matches = (
                        this.document || this.ownerDocument
                    ).querySelectorAll(s),
                    i = matches.length
                while (--i >= 0 && matches.item(i) !== this) {}
                return i > -1
            }
    }

    for (; elem && elem !== document; elem = elem.parentNode) {
        if (elem.matches(selector)) return elem
    }
    return null
}

function activateMenu() {
    let menuItems = document.getElementsByClassName('sub-menu-item')
    if (menuItems) {
        let matchingMenuItem = null
        for (let idx = 0; idx < menuItems.length; idx++) {
            if (menuItems[idx].href === window.location.href) {
                matchingMenuItem = menuItems[idx]
            }
        }

        if (matchingMenuItem) {
            matchingMenuItem.classList.add('active')
            let immediateParent = getClosest(matchingMenuItem, 'li')
            if (immediateParent) {
                immediateParent.classList.add('active')
            }

            let parent = getClosest(matchingMenuItem, '.parent-menu-item')
            if (parent) {
                parent.classList.add('active')
                let parentMenuitem = parent.querySelector('.menu-item')
                if (parentMenuitem) {
                    parentMenuitem.classList.add('active')
                }
                let parentOfParent = getClosest(
                    parent,
                    '.parent-parent-menu-item'
                )
                if (parentOfParent) {
                    parentOfParent.classList.add('active')
                }
            } else {
                let parentOfParent = getClosest(
                    matchingMenuItem,
                    '.parent-parent-menu-item'
                )
                if (parentOfParent) {
                    parentOfParent.classList.add('active')
                }
            }
        }
    }
}

if (document.getElementById('navigation')) {
    let elements = document
        .getElementById('navigation')
        .getElementsByTagName('a')
    for (let i = 0, len = elements.length; i < len; i++) {
        elements[i].onclick = function (elem) {
            if (elem.currentTarget.parentElement.classList.contains('has-submenu')) {
                elem.preventDefault()
                let submenu = elem.target.nextElementSibling.nextElementSibling
                submenu.classList.toggle('open')
            }
        }
    }
}
function windowScroll() {
    const navbar = document.getElementById('topnav')
    if (navbar != null) {
        if (
            document.body.scrollTop >= 50 ||
            document.documentElement.scrollTop >= 50
        ) {
            navbar.classList.add('nav-sticky')
            if ($('.breadcrumb').length) {
                if ($('.nav-light').length) {
                    $('#button-language-switcher').removeClass('language-switcher-nav-light')
                } else {
                    $('#button-language-switcher').addClass('language-switcher-nav-light')
                }
            } else {
                $('#button-language-switcher').removeClass('language-switcher-nav-light')
            }
        } else {
            navbar.classList.remove('nav-sticky')
            if ($('.breadcrumb').length) {
                $('#button-language-switcher').addClass('language-switcher-nav-light')
            } else {
                $('#button-language-switcher').removeClass('language-switcher-nav-light')
            }
        }
    }
}

window.addEventListener('scroll', (ev) => {
    ev.preventDefault()
    windowScroll()
})

window.onscroll = function () {
    scrollFunction()
}

window.onload = () => {
    windowScroll()
}

function scrollFunction() {
    let mybutton = document.getElementById('back-to-top')
    if (mybutton != null) {
        if (
            document.body.scrollTop > 500 ||
            document.documentElement.scrollTop > 500
        ) {
            mybutton.classList.add('flex')
            mybutton.classList.remove('hidden')
        } else {
            mybutton.classList.add('hidden')
            mybutton.classList.remove('flex')
        }
    }
}

(function () {
    let current = location.pathname.substring()
    if (current === '') return
    let menuItems = document.querySelectorAll('.sidebar-nav a')
    for (let i = 0, len = menuItems.length; i < len; i++) {
        if (menuItems[i].getAttribute('href').indexOf(current) !== -1) {
            menuItems[i].parentElement.className += ' active'
        }
    }
})()

feather.replace()

try {
    let spy = new Gumshoe('#navmenu-nav a')
} catch (err) {}

try {
    function validateForm() {
        let name = document.forms['myForm']['name'].value
        let email = document.forms['myForm']['email'].value
        let subject = document.forms['myForm']['subject'].value
        let comments = document.forms['myForm']['comments'].value
        document.getElementById('error-msg').style.opacity = 0
        document.getElementById('error-msg').innerHTML = ''
        if (name === '' || name == null) {
            document.getElementById('error-msg').innerHTML = fadeIn()
            return false
        }
        if (email === '' || email == null) {
            document.getElementById('error-msg').innerHTML = fadeIn()
            return false
        }
        if (subject === '' || subject == null) {
            document.getElementById('error-msg').innerHTML = fadeIn()
            return false
        }
        if (comments === '' || comments == null) {
            document.getElementById('error-msg').innerHTML = fadeIn()
            return false
        }
        let xhttp = new XMLHttpRequest()
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('simple-msg').innerHTML = this.responseText
                document.forms['myForm']['name'].value = ''
                document.forms['myForm']['email'].value = ''
                document.forms['myForm']['subject'].value = ''
                document.forms['myForm']['comments'].value = ''
            }
        }
        xhttp.setRequestHeader('Content-type')
        xhttp.send(
            'name=' +
                name +
                '&email=' +
                email +
                '&subject=' +
                subject +
                '&comments=' +
                comments
        )
        return false
    }

    function fadeIn() {
        let fade = document.getElementById('error-msg')
        let opacity = 0
        let intervalID = setInterval(function () {
            if (opacity < 1) {
                opacity = opacity + 0.5
                fade.style.opacity = opacity
            } else {
                clearInterval(intervalID)
            }
        }, 200)
    }
} catch (error) {}

try {
    const switcher = document.getElementById('theme-mode')
    switcher?.addEventListener('click', changeTheme)

    const chk = document.getElementById('chk')

    chk.addEventListener('change', changeTheme)

    const defaultTheme = window.defaultThemeMode || 'system'

    if (
        getCookie('theme') === 'dark'
        || defaultTheme === 'dark'
        || (window.matchMedia('(prefers-color-scheme: dark)').matches && defaultTheme === 'system')
    ) {
        chk.checked = true
        document.documentElement.classList.add('dark')
    } else {
        chk.checked = false
        document.documentElement.classList.remove('dark')
    }

    function changeTheme(e) {
        e.preventDefault()
        const htmlTag = document.getElementsByTagName('html')[0]

        if (htmlTag.className.includes('dark')) {
            setCookie('theme', 'light')
            htmlTag.className = 'light'
        } else {
            setCookie('theme', 'dark')
            htmlTag.className = 'dark'
        }
    }
} catch (err) {}

try {
    const htmlTag = document.getElementsByTagName('html')[0]
    function changeLayout(e) {
        e.preventDefault()
        const switcherRtl = document.getElementById('switchRtl')
        if (switcherRtl.innerText === 'LTR') {
            htmlTag.dir = 'ltr'
        } else {
            htmlTag.dir = 'rtl'
        }
    }
    const switcherRtl = document.getElementById('switchRtl')
    switcherRtl?.addEventListener('click', changeLayout)
} catch (err) {}

if (document.getElementsByClassName('tiny-single-item').length > 0) {
    tns({
        container: '.tiny-single-item',
        items: 1,
        controls: false,
        mouseDrag: true,
        loop: true,
        rewind: true,
        autoplay: true,
        autoplayButtonOutput: false,
        autoplayTimeout: 3000,
        navPosition: 'bottom',
        speed: 400,
        gutter: 16,
    })
}

if (document.getElementsByClassName('tiny-three-item').length > 0) {
    tns({
        container: '.tiny-three-item',
        items: 3,
        controls: false,
        mouseDrag: true,
        loop: true,
        rewind: true,
        autoplay: true,
        autoplayButtonOutput: false,
        autoplayTimeout: 3000,
        navPosition: 'bottom',
        speed: 400,
        gutter: 16,
        responsive: {
            992: {
                items: 3,
            },

            767: {
                items: 2,
            },

            320: {
                items: 1,
            },
        },
    })
}

if (document.getElementsByClassName('tiny-home-slide-three').length > 0) {
    tns({
        container: '.tiny-home-slide-three',
        controls: true,
        mouseDrag: true,
        loop: true,
        rewind: true,
        autoplay: true,
        autoplayButtonOutput: false,
        autoplayTimeout: 3000,
        navPosition: 'bottom',
        nav: false,
        speed: 400,
        gutter: 0,
        responsive: {
            992: {
                items: 3,
            },

            767: {
                items: 2,
            },

            320: {
                items: 1,
            },
        },
    })
}

const initTns = (element) => {
    if (document.querySelectorAll(element).length > 0) {
        tns({
            container: element,
            controls: true,
            mouseDrag: true,
            loop: true,
            rewind: true,
            autoplay: true,
            autoplayButtonOutput: false,
            autoplayTimeout: 3000,
            navPosition: 'bottom',
            nav: false,
            speed: 400,
            gutter: 16,
            controlsContainer: "#customize-controls",
            responsive: {
                992: {
                    items: 4,
                },

                767: {
                    items: 2,
                },

                320: {
                    items: 1,
                },
            },
        })
    }
}

initTns('.tiny-properties-location-slide-four')
initTns('.tiny-projects-location-slide-four')

try {
    const counter = document.querySelectorAll('.counter-value')
    const speed = 2500

    counter.forEach((counter_value) => {
        const updateCount = () => {
            const target = +counter_value.getAttribute('data-target')
            const count = +counter_value.innerText

            let inc = target / speed

            if (inc < 1) {
                inc = 1
            }

            if (count < target) {
                counter_value.innerText = (count + inc).toFixed(0)
                setTimeout(updateCount, 1)
            } else {
                counter_value.innerText = target
            }
        }

        updateCount()
    })
} catch (err) {}

try {
    new Tobii()
} catch (err) {}

document
    .getElementsByClassName('back-button')[0]
    ?.addEventListener('click', (e) => {
        if (document.referrer !== '') {
            e.preventDefault()
            window.location.href = document.referrer
        }
    })

try {
    particlesJS('particles-snow', {
        particles: {
            number: {
                value: 250,
                density: {
                    enable: false,
                    value_area: 800,
                },
            },
            color: {
                value: '#ffffff',
            },
            shape: {
                type: 'circle',
                stroke: {
                    width: 0,
                    color: '#000000',
                },
                polygon: {
                    nb_sides: 36,
                },
                image: {
                    src: '',
                    width: 1000,
                    height: 1000,
                },
            },
            opacity: {
                value: 0.5,
                random: false,
                anim: {
                    enable: false,
                    speed: 0.5,
                    opacity_min: 1,
                    sync: false,
                },
            },
            size: {
                value: 3.2,
                random: true,
                anim: {
                    enable: false,
                    speed: 20,
                    size_min: 0.1,
                    sync: false,
                },
            },
            line_linked: {
                enable: false,
                distance: 100,
                color: '#ffffff',
                opacity: 0.4,
                width: 2,
            },
            move: {
                enable: true,
                speed: 1,
                direction: 'bottom',
                random: false,
                straight: false,
                out_mode: 'out',
                bounce: false,
                attract: {
                    enable: false,
                    rotateX: 800,
                    rotateY: 1200,
                },
            },
        },
        interactivity: {
            detect_on: 'canvas',
            events: {
                onhover: {
                    enable: false,
                    mode: 'repulse',
                },
                onclick: {
                    enable: false,
                    mode: 'push',
                },
                resize: true,
            },
            modes: {
                grab: {
                    distance: 200,
                    line_linked: {
                        opacity: 1,
                    },
                },
                bubble: {
                    distance: 400,
                    size: 40,
                    duration: 2,
                    opacity: 8,
                    speed: 3,
                },
                repulse: {
                    distance: 71,
                    duration: 0.4,
                },
                push: {
                    particles_nb: 4,
                },
                remove: {
                    particles_nb: 2,
                },
            },
        },
        retina_detect: true,
    })
} catch (error) {}

try {
    const Default = {
        defaultTabId: null,
        activeClasses: 'text-white bg-primary',
        inactiveClasses: 'hover:text-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-slate-800',
        onShow: () => {},
    }

    class Tabs {
        constructor(items = [], options = {}) {
            this._items = items
            this._activeTab = options ? this.getTab(options.defaultTabId) : null
            this._options = { ...Default, ...options }
            this._init()
        }

        _init() {
            if (this._items.length) {
                if (!this._activeTab) {
                    this._setActiveTab(this._items[0])
                }

                this.show(this._activeTab.id, true)

                this._items.map((tab) => {
                    tab.triggerEl.addEventListener('click', () => {
                        this.show(tab.id)
                    })
                })
            }
        }

        getActiveTab() {
            return this._activeTab
        }

        _setActiveTab(tab) {
            this._activeTab = tab
        }

        getTab(id) {
            return this._items.filter((t) => t.id === id)[0]
        }

        show(id, forceShow = false) {
            const tab = this.getTab(id)

            if (tab === this._activeTab && !forceShow) {
                return
            }

            this._items.map((t) => {
                if (t !== tab) {
                    t.triggerEl.classList.remove(
                        ...this._options.activeClasses.split(' ')
                    )
                    t.triggerEl.classList.add(
                        ...this._options.inactiveClasses.split(' ')
                    )
                    t.targetEl.classList.add('hidden')
                    t.triggerEl.setAttribute('aria-selected', false)
                }
            })

            tab.triggerEl.classList.add(...this._options.activeClasses.split(' '))
            tab.triggerEl.classList.remove(...this._options.inactiveClasses.split(' '))
            tab.triggerEl.setAttribute('aria-selected', true)
            tab.targetEl.classList.remove('hidden')

            this._setActiveTab(tab)

            this._options.onShow(this, tab)
        }
    }

    window.Tabs = Tabs

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-tabs-toggle]').forEach((triggerEl) => {
            const tabElements = []
            let defaultTabId = null
            triggerEl.querySelectorAll('[role="tab"]').forEach((el) => {
                const isActive = el.getAttribute('aria-selected') === 'true'
                const tab = {
                    id: el.getAttribute('data-tabs-target'),
                    triggerEl: el,
                    targetEl: document.querySelector(el.getAttribute('data-tabs-target')),
                }
                tabElements.push(tab)

                if (isActive) {
                    defaultTabId = tab.id
                }
            })
            new Tabs(tabElements, {
                defaultTabId: defaultTabId,
            })
        })
    })
} catch (error) {}

try {
    const Default = {
        placement: 'center',
        backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
        onHide: () => {},
        onShow: () => {},
        onToggle: () => {},
    }
    class Modal {
        constructor(targetEl = null, options = {}) {
            this._targetEl = targetEl
            this._options = { ...Default, ...options }
            this._isHidden = true
            this._init()
        }

        _init() {
            this._getPlacementClasses().map((c) => {
                this._targetEl.classList.add(c)
            })
        }

        _createBackdrop() {
            if (this._isHidden) {
                const backdropEl = document.createElement('div')
                backdropEl.setAttribute('modal-backdrop', '')
                backdropEl.classList.add(
                    ...this._options.backdropClasses.split(' ')
                )
                document.querySelector('body').append(backdropEl)
            }
        }

        _destroyBackdropEl() {
            if (!this._isHidden) {
                document.querySelector('[modal-backdrop]').remove()
            }
        }

        _getPlacementClasses() {
            switch (this._options.placement) {
                case 'top-left':
                    return ['justify-start', 'items-start']
                case 'top-center':
                    return ['justify-center', 'items-start']
                case 'top-right':
                    return ['justify-end', 'items-start']
                case 'center-left':
                    return ['justify-start', 'items-center']
                case 'center':
                    return ['justify-center', 'items-center']
                case 'center-right':
                    return ['justify-end', 'items-center']

                case 'bottom-left':
                    return ['justify-start', 'items-end']
                case 'bottom-center':
                    return ['justify-center', 'items-end']
                case 'bottom-right':
                    return ['justify-end', 'items-end']
                default:
                    return ['justify-center', 'items-center']
            }
        }

        toggle() {
            if (this._isHidden) {
                this.show()
            } else {
                this.hide()
            }

            this._options.onToggle(this)
        }

        show() {
            this._targetEl.classList.add('flex')
            this._targetEl.classList.remove('hidden')
            this._targetEl.setAttribute('aria-modal', 'true')
            this._targetEl.setAttribute('role', 'dialog')
            this._targetEl.removeAttribute('aria-hidden')
            this._createBackdrop()
            this._isHidden = false

            this._options.onShow(this)
        }

        hide() {
            this._targetEl.classList.add('hidden')
            this._targetEl.classList.remove('flex')
            this._targetEl.setAttribute('aria-hidden', 'true')
            this._targetEl.removeAttribute('aria-modal')
            this._targetEl.removeAttribute('role')
            this._destroyBackdropEl()
            this._isHidden = true

            this._options.onHide(this)
        }
    }

    window.Modal = Modal

    const getModalInstance = (id, instances) => {
        if (instances.some((modalInstance) => modalInstance.id === id)) {
            return instances.find((modalInstance) => modalInstance.id === id)
        }
        return false
    }

    document.addEventListener('DOMContentLoaded', () => {
        let modalInstances = []
        document.querySelectorAll('[data-modal-toggle]').forEach((el) => {
            const modalId = el.getAttribute('data-modal-toggle')
            const modalEl = document.getElementById(modalId)
            const placement = modalEl.getAttribute('data-modal-placement')

            if (modalEl) {
                if (
                    !modalEl.hasAttribute('aria-hidden') &&
                    !modalEl.hasAttribute('aria-modal')
                ) {
                    modalEl.setAttribute('aria-hidden', 'true')
                }
            }

            let modal = null
            if (getModalInstance(modalId, modalInstances)) {
                modal = getModalInstance(modalId, modalInstances)
                modal = modal.object
            } else {
                modal = new Modal(modalEl, {
                    placement: placement ? placement : Default.placement,
                })
                modalInstances.push({
                    id: modalId,
                    object: modal,
                })
            }

            el.addEventListener('click', () => {
                modal.toggle()
            })
        })
    })
} catch (error) {}

try {
    const Default = {
        defaultPosition: 0,
        indicators: {
            items: [],
            activeClasses: 'bg-white dark:bg-gray-800',
        },
        interval: 6000,
        onNext: () => {},
        onPrev: () => {},
        onChange: () => {},
    }

    class Carousel {
        constructor(items = [], options = {}) {
            this._items = items
            this._options = {
                ...Default,
                ...options,
                indicators: { ...Default.indicators, ...options.indicators },
            }
            this._activeItem = this.getItem(this._options.defaultPosition)
            this._indicators = this._options.indicators.items
            this._interval = null
            this._init()
            this.cycle()
        }

        _init() {
            this._items.map((item) => {
                item.el.classList.add(
                    'absolute',
                    'inset-0',
                    'transition-all',
                    'transform'
                )
            })

            if (this._getActiveItem()) {
                this.slideTo(this._getActiveItem().position)
            } else {
                this.slideTo(0)
            }

            this._indicators.map((indicator, position) => {
                indicator.el.addEventListener('click', () => {
                    this.slideTo(position)
                })
            })
        }

        getItem(position) {
            return this._items[position]
        }

        slideTo(position) {
            const nextItem = this._items[position]
            const rotationItems = {
                left:
                    nextItem.position === 0
                        ? this._items[this._items.length - 1]
                        : this._items[nextItem.position - 1],
                middle: nextItem,
                right:
                    nextItem.position === this._items.length - 1
                        ? this._items[0]
                        : this._items[nextItem.position + 1],
            }
            this._rotate(rotationItems)
            this._setActiveItem(nextItem.position)
            if (this._interval) {
                this.pause()
                this.cycle()
            }

            this._options.onChange(this)
        }

        next() {
            const activeItem = this._getActiveItem()
            let nextItem = null

            if (activeItem.position === this._items.length - 1) {
                nextItem = this._items[0]
            } else {
                nextItem = this._items[activeItem.position + 1]
            }

            this.slideTo(nextItem.position)

            this._options.onNext(this)
        }

        prev() {
            const activeItem = this._getActiveItem()
            let prevItem = null

            if (activeItem.position === 0) {
                prevItem = this._items[this._items.length - 1]
            } else {
                prevItem = this._items[activeItem.position - 1]
            }

            this.slideTo(prevItem.position)

            this._options.onPrev(this)
        }

        _rotate(rotationItems) {
            this._items.map((item) => {
                item.el.classList.add('hidden')
            })

            rotationItems.left.el.classList.remove(
                '-translate-x-full',
                'translate-x-full',
                'translate-x-0',
                'hidden',
                'z-20'
            )
            rotationItems.left.el.classList.add('-translate-x-full', 'z-10')

            rotationItems.middle.el.classList.remove(
                '-translate-x-full',
                'translate-x-full',
                'translate-x-0',
                'hidden',
                'z-10'
            )
            rotationItems.middle.el.classList.add('translate-x-0', 'z-20')

            rotationItems.right.el.classList.remove(
                '-translate-x-full',
                'translate-x-full',
                'translate-x-0',
                'hidden',
                'z-20'
            )
            rotationItems.right.el.classList.add('translate-x-full', 'z-10')
        }

        cycle() {
            this._interval = setInterval(() => {
                this.next()
            }, this._options.interval)
        }

        pause() {
            clearInterval(this._interval)
        }

        _getActiveItem() {
            return this._activeItem
        }

        _setActiveItem(position) {
            this._activeItem = this._items[position]

            if (this._indicators.length) {
                this._indicators.map((indicator) => {
                    indicator.el.setAttribute('aria-current', 'false')
                    indicator.el.classList.remove(
                        ...this._options.indicators.activeClasses.split(' ')
                    )
                    indicator.el.classList.add(
                        ...this._options.indicators.inactiveClasses.split(' ')
                    )
                })
                this._indicators[position].el.classList.add(
                    ...this._options.indicators.activeClasses.split(' ')
                )
                this._indicators[position].el.classList.remove(
                    ...this._options.indicators.inactiveClasses.split(' ')
                )
                this._indicators[position].el.setAttribute(
                    'aria-current',
                    'true'
                )
            }
        }
    }

    window.Carousel = Carousel

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-carousel]').forEach((carouselEl) => {
            const interval = carouselEl.getAttribute('data-carousel-interval')
            const slide =
                carouselEl.getAttribute('data-carousel') === 'slide'
                    ? true
                    : false

            const items = []
            let defaultPosition = 0
            if (carouselEl.querySelectorAll('[data-carousel-item]').length) {
                [...carouselEl.querySelectorAll('[data-carousel-item]')].map(
                    (carouselItemEl, position) => {
                        items.push({
                            position: position,
                            el: carouselItemEl,
                        })

                        if (
                            carouselItemEl.getAttribute(
                                'data-carousel-item'
                            ) === 'active'
                        ) {
                            defaultPosition = position
                        }
                    }
                )
            }

            const indicators = []
            if (
                carouselEl.querySelectorAll('[data-carousel-slide-to]').length
            ) {
                [
                    ...carouselEl.querySelectorAll('[data-carousel-slide-to]'),
                ].map((indicatorEl) => {
                    indicators.push({
                        position: indicatorEl.getAttribute(
                            'data-carousel-slide-to'
                        ),
                        el: indicatorEl,
                    })
                })
            }

            const carousel = new Carousel(items, {
                defaultPosition: defaultPosition,
                indicators: {
                    items: indicators,
                },
                interval: interval ? interval : Default.interval,
            })

            if (slide) {
                carousel.cycle()
            }

            const carouselNextEl = carouselEl.querySelector(
                '[data-carousel-next]'
            )
            const carouselPrevEl = carouselEl.querySelector(
                '[data-carousel-prev]'
            )

            if (carouselNextEl) {
                carouselNextEl.addEventListener('click', () => {
                    carousel.next()
                })
            }

            if (carouselPrevEl) {
                carouselPrevEl.addEventListener('click', () => {
                    carousel.prev()
                })
            }
        })
    })
} catch (error) {}

try {
    const Default = {
        alwaysOpen: false,
        activeClasses: 'bg-gray-50 dark:bg-slate-800 text-primary',
        inactiveClasses: 'text-dark dark:text-white',
        onOpen: () => {},
        onClose: () => {},
        onToggle: () => {},
    }

    class Accordion {
        constructor(items = [], options = {}) {
            this._items = items
            this._options = { ...Default, ...options }
            this._init()
        }

        _init() {
            if (this._items.length) {
                this._items.map((item) => {
                    if (item.active) {
                        this.open(item.id)
                    }

                    item.triggerEl.addEventListener('click', () => {
                        this.toggle(item.id)
                    })
                })
            }
        }

        getItem(id) {
            return this._items.filter((item) => item.id === id)[0]
        }

        open(id) {
            const item = this.getItem(id)

            if (!this._options.alwaysOpen) {
                this._items.map((i) => {
                    if (i !== item) {
                        i.triggerEl.classList.remove(
                            ...this._options.activeClasses.split(' ')
                        )
                        i.triggerEl.classList.add(
                            ...this._options.inactiveClasses.split(' ')
                        )
                        i.targetEl.classList.add('hidden')
                        i.triggerEl.setAttribute('aria-expanded', false)
                        i.active = false

                        if (i.iconEl) {
                            i.iconEl.classList.remove('rotate-180')
                        }
                    }
                })
            }

            item.triggerEl.classList.add(
                ...this._options.activeClasses.split(' ')
            )
            item.triggerEl.classList.remove(
                ...this._options.inactiveClasses.split(' ')
            )
            item.triggerEl.setAttribute('aria-expanded', true)
            item.targetEl.classList.remove('hidden')
            item.active = true

            if (item.iconEl) {
                item.iconEl.classList.add('rotate-180')
            }

            this._options.onOpen(this, item)
        }

        toggle(id) {
            const item = this.getItem(id)

            if (item.active) {
                this.close(id)
            } else {
                this.open(id)
            }

            this._options.onToggle(this, item)
        }

        close(id) {
            const item = this.getItem(id)

            item.triggerEl.classList.remove(
                ...this._options.activeClasses.split(' ')
            )
            item.triggerEl.classList.add(
                ...this._options.inactiveClasses.split(' ')
            )
            item.targetEl.classList.add('hidden')
            item.triggerEl.setAttribute('aria-expanded', false)
            item.active = false

            if (item.iconEl) {
                item.iconEl.classList.remove('rotate-180')
            }

            this._options.onClose(this, item)
        }
    }

    window.Accordion = Accordion

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-accordion]').forEach((accordionEl) => {
            const alwaysOpen = accordionEl.getAttribute('data-accordion')
            const activeClasses = accordionEl.getAttribute(
                'data-active-classes'
            )
            const inactiveClasses = accordionEl.getAttribute(
                'data-inactive-classes'
            )

            const items = []
            accordionEl
                .querySelectorAll('[data-accordion-target]')
                .forEach((el) => {
                    const item = {
                        id: el.getAttribute('data-accordion-target'),
                        triggerEl: el,
                        targetEl: document.querySelector(
                            el.getAttribute('data-accordion-target')
                        ),
                        iconEl: el.querySelector('[data-accordion-icon]'),
                        active: el.getAttribute('aria-expanded') === 'true',
                    }
                    items.push(item)
                })

            new Accordion(items, {
                alwaysOpen: alwaysOpen === 'open',
                activeClasses: activeClasses
                    ? activeClasses
                    : Default.activeClasses,
                inactiveClasses: inactiveClasses
                    ? inactiveClasses
                    : Default.inactiveClasses,
            })
        })
    })
} catch (error) {}

try {
    const rangeSlider = document.getElementById('slider')
    const value = rangeSlider.value
    document.getElementById('amount-label').innerHTML = value
    document.getElementById('saving-label').innerHTML = parseFloat(value * 0.01).toFixed(2)
    rangeSlider.addEventListener('input', function () {
        const value = rangeSlider.value
        document.getElementById('amount-label').innerHTML = value
        document.getElementById('saving-label').innerHTML = parseFloat(value * 0.01).toFixed(2)
    })
} catch (error) {}

const choicesElements = [
    '#choices-category-projects',
    '#choices-category-sale',
    '#choices-bedrooms-sale',
    '#choices-bathrooms-sale',
    '#choices-floors-sale',
    '#choices-type-rent',
    '#choices-blocks-rent',
    '#choices-category-rent',
    '#choices-bedrooms-rent',
    '#choices-bathrooms-rent',
    '#choices-floors-rent',
    '#choices-category-mobile',
    '#choices-bedrooms-mobile',
    '#choices-bathrooms-mobile',
    '#choices-floors-mobile',
    '#choices-type-mobile',
    '#choices-blocks-mobile',
]

choicesElements.forEach((element) => {
    if (document.getElementById(element.replace('#', ''))) {
        new Choices(element, {allowHTML: false, searchEnabled: false})
    }
})

try {
    if (document.getElementById('maintenance')) {
        let seconds = 3599
        function secondPassed() {
            let remainingSeconds = seconds % 60
            if (remainingSeconds < 10) {
                remainingSeconds = '0' + remainingSeconds
            }
            document.getElementById('maintenance').innerHTML =
                minutes + ':' + remainingSeconds
            if (seconds === 0) {
                clearInterval(countdownTimer)
                document.getElementById('maintenance').innerHTML = 'Buzz Buzz'
            } else {
                seconds--
            }
        }
        let countdownTimer = setInterval('secondPassed()', 1000)
    }
} catch (err) {}

try {
    if (document.getElementById('days')) {
        const time = $('#countdown').find('.time-end').val()
        let eventCountDown = new Date(time).getTime()

        let myfunc = setInterval(function () {
            let now = new Date().getTime()
            let timeleft = eventCountDown - now

            let days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
            let hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

            document.getElementById("days").innerHTML = days + "<p class='count-head'>Days</p> "
            document.getElementById("hours").innerHTML = hours + "<p class='count-head'>Hours</p> "
            document.getElementById("mins").innerHTML = minutes + "<p class='count-head'>Mins</p> "
            document.getElementById("secs").innerHTML = seconds + "<p class='count-head'>Secs</p> "


            if (timeleft < 0) {
                clearInterval(myfunc)
                document.getElementById('days').innerHTML = ''
                document.getElementById('hours').innerHTML = ''
                document.getElementById('mins').innerHTML = ''
                document.getElementById('secs').innerHTML = ''
                document.getElementById('end').innerHTML = '00:00:00:00'
            }
        }, 1000)
    }
} catch (err) {}

$('.newsletter-form button[type=submit]').on('click', function (event) {
    event.preventDefault();
    event.stopPropagation();

    let _self = $(this);
    $.ajax({
        type: 'POST',
        cache: false,
        url: _self.closest('form').prop('action'),
        data: new FormData(_self.closest('form')[0]),
        contentType: false,
        processData: false,
        beforeSend: () => {
            _self.addClass('button-loading');
        },
        success: res => {
            if (!res.error) {
                _self.closest('form').find('input[type=email]').val('');
                showSuccess(res.message);
            } else {
                showError(res.message);
            }
        },
        error: res => {
            handleError(res);
        },
        complete: () => {
            if (typeof refreshRecaptcha !== 'undefined') {
                refreshRecaptcha();
            }
            _self.removeClass('button-loading');
        },
    });
});

$(document).on('click', '.generic-form button[type=submit]', function (event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).prop('disabled', true).addClass('button-loading');

    $.ajax({
        type: 'POST',
        cache: false,
        url: $(this).closest('form').prop('action'),
        data: new FormData($(this).closest('form')[0]),
        contentType: false,
        processData: false,
        success: res => {
            $(this).closest('form').find('.text-success').html('').hide();
            $(this).closest('form').find('.text-danger').html('').hide();

            if (!res.error) {
                $(this).closest('form').find('input[type=text]:not([readonly])').val('');
                $(this).closest('form').find('input[type=email]').val('');
                $(this).closest('form').find('input[type=number]').val('');
                $(this).closest('form').find('input[type=url]').val('');
                $(this).closest('form').find('input[type=tel]').val('');
                $(this).closest('form').find('select').val('');
                $(this).closest('form').find('textarea').val('');

                showSuccess(res.message);

                if (res.data && res.data.next_page) {
                    window.location.href = res.data.next_page;
                }
            } else {
                showError(res.message);
            }

            if (typeof refreshRecaptcha !== 'undefined') {
                refreshRecaptcha();
            }

            $(this).prop('disabled', false).removeClass('button-loading');
        },
        error: res => {
            if (typeof refreshRecaptcha !== 'undefined') {
                refreshRecaptcha();
            }
            $(this).prop('disabled', false).removeClass('button-loading');
            handleError(res, $(this).closest('form'));
        }
    });
});

window.propertyMaps = {};
function setPropertyMap($el) {
    let uid = $el.data('uid');
    if (!uid) {
        uid = (Math.random() + 1).toString(36).substring(7) + (new Date().getTime());
        $el.data('uid', uid);
    }
    if (propertyMaps[uid]) {
        propertyMaps[uid].off();
        propertyMaps[uid].remove();
    }

    propertyMaps[uid] = L.map($el[0], {
        zoomControl: false,
        scrollWheelZoom: true,
        dragging: true,
        maxZoom: $el.data('max-zoom') || 20
    }).setView($el.data('center'), $el.data('zoom') || 14);

    let myIcon = L.divIcon({
        className: 'boxmarker',
        iconSize: L.point(50, 20),
        html: $el.data('map-icon')
    });
    L.tileLayer($el.data('tile-layer') ? $el.data('tile-layer') : 'https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}').addTo(propertyMaps[uid]);

    L.marker($el.data('center'), {icon: myIcon})
        .addTo(propertyMaps[uid])
        .bindPopup($el.find('.property-template-popup-map').html())
        .openPopup();
}

let property = $('.property-street-map');

if (property.length) {
    property.each(function (i, e) {
        setPropertyMap($(e));
    });
}

$(document).on('mouseover', '#button-language-switcher', function () {
    let dropdown = $('.dropdown-language-switcher');
    const hide = 'transform opacity-0 scale-95 hidden';
    dropdown.removeClass(hide)
});

$(document).on('mouseleave', 'li.wrapper-dropdown-language-switcher', function () {
    let dropdown = $('.dropdown-language-switcher');
    const hide = 'transform opacity-0 scale-95 hidden';
    dropdown.addClass(hide)
});

const handleRecentlyViewedProperties = () => {
    const cookieName = 'recently_viewed_properties'
    const propertyId = $('section[data-property-id]').data('property-id')

    if (! propertyId) return

    const recentPropertyCookies = decodeURIComponent(getCookie(cookieName));

    let propertiesList = [];
    if (recentPropertyCookies !== null && recentPropertyCookies !== undefined && recentPropertyCookies.length > 0)
        propertiesList = JSON.parse(getCookie(cookieName));

    if (propertyId !== 0 && propertyId !== undefined) {
        let item = {id: propertyId};
        if (recentPropertyCookies === undefined || recentPropertyCookies === null || recentPropertyCookies === '') {
            propertiesList.push(item);

            setCookie(cookieName, JSON.stringify(propertiesList), 60);
        } else {
            propertiesList = JSON.parse(recentPropertyCookies);
            const index = propertiesList.map(e => {
                return e.id;
            }).indexOf(item.id);

            if (index === -1) {
                if (propertiesList.length >= 20) {
                    propertiesList.shift()
                }
                propertiesList.push(item);
                clearCookies(cookieName);
                setCookie(cookieName, JSON.stringify(propertiesList), 60);
            } else {
                propertiesList.splice(index, 1);
                propertiesList.push(item);
                clearCookies(cookieName);
                setCookie(cookieName, JSON.stringify(propertiesList), 60);
            }
        }
    }
}

handleRecentlyViewedProperties()
function initMaps() {
    let $map = $('#map');
    if (!$map.length) {
        return;
    }
    if ($('.view-type-map').length && !$('.view-type-map').hasClass('active')) {
        return;
    }

    let totalPage = 0;
    let currentPage = 1;
    let params = searchToObject();
    let center = $map.data('center');
    const centerFirst = $('#properties-list .property-item[data-lat][data-long]').filter(function () {
        return $(this).data('lat') && $(this).data('long')
    });
    if (centerFirst && centerFirst.length) {
        center = [centerFirst.data('lat'), centerFirst.data('long')]
    }
    if (window.activeMap) {
        window.activeMap.off();
        window.activeMap.remove();
    }

    let map = L.map('map', {
        zoomControl: true,
        scrollWheelZoom: true,
        dragging: true,
        maxZoom: $map.data('max-zoom') || 18
    }).setView(center, 14);

    L.tileLayer($map.data('tile-layer') ? $map.data('tile-layer') : 'https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}').addTo(map);

    const markers = new L.MarkerClusterGroup();
    let markersList = [];
    let $templatePopup = $('#traffic-popup-map-template').html();

    function populate() {
        if ((totalPage == 0) || currentPage <= totalPage) {
            params.page = currentPage;
            $.ajax({
                url: $map.data('url'),
                type: 'GET',
                data: params,
                success: function (res) {
                    if (res.data.length > 0) {
                        res.data.forEach(house => {
                            if (house.latitude && house.longitude) {
                                var myIcon = L.divIcon({
                                    className: 'boxmarker',
                                    iconSize: L.point(50, 20),
                                    html: house.map_icon
                                });
                                let popup = templateReplace(house, $templatePopup);
                                var m = new L.Marker(new L.LatLng(house.latitude, house.longitude), {icon: myIcon})
                                    .bindPopup(popup)
                                    .addTo(map);
                                markersList.push(m);
                                markers.addLayer(m);

                                map.flyToBounds(L.latLngBounds(markersList.map(marker => marker.getLatLng())));
                            }
                        });
                        if (totalPage == 0) {
                            totalPage = res.meta.last_page
                        }
                        currentPage++;
                        populate();
                    }
                }
            });
        }

        return false;
    }

    populate();
    map.addLayer(markers);

    window.activeMap = map;
}

function searchToObject() {
    let pairs = window.location.search.substring(1).split('&'),
        obj = {},
        pair,
        i;

    for (i in pairs) {
        if (pairs[i] === '') continue;

        pair = pairs[i].split('=');
        obj[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
    }

    return obj;
}

function templateReplace(data, template) {
    const keys = Object.keys(data);
    for (const i in keys) {
        if (keys.hasOwnProperty(i)) {
            const key = keys[i]
            template = template.replace(new RegExp('__' + key + '__', 'gi'), data[key] || '')
        }
    }
    return template;
}

if ($('#map').length) {
    initMaps();
}

if ($('#navigation').find($('.nav-light')).length) {
    $('#button-language-switcher').addClass('language-switcher-nav-light')
} else {
    $('#button-language-switcher').removeClass('language-switcher-nav-light')
}

$(document).on('click', '#button-currency-switcher', function () {
    const dropdown = $('.dropdown-currency-switcher')
    const hide = 'transform opacity-0 scale-95 hidden'

    if (dropdown.hasClass(hide)) {
        dropdown.removeClass(hide)
    } else {
        dropdown.addClass(hide)
    }
});

$(document).on('click', (e) => {
    if (! $(e.target).closest('#button-currency-switcher').length) {
        const dropdown = $('.dropdown-currency-switcher')
        const hide = 'transform opacity-0 scale-95 hidden'

        if (! dropdown.hasClass(hide)) {
            dropdown.addClass(hide)
        }
    }
})

$(document).on('click', '#alert-container .close', function () {
    $(this).closest('.alert').remove();
})
