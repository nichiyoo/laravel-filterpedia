import EmblaCarousel from 'embla-carousel'
import AutoScroll from 'embla-carousel-auto-scroll'
import Fade from 'embla-carousel-fade'

const categories = document.querySelector('.categories')
if (categories) {
    EmblaCarousel(categories, {
        loop: true,
        align: 'start',
    })
}

const brands = document.querySelector('.brands')
if (brands) {
    EmblaCarousel(brands, {
        loop: true,
        align: 'start',
    }, [
        AutoScroll({
            speed: 0.5,
            startDelay: 0,
            playOnInit: true,
            stopOnMouseEnter: true,
            stopOnInteraction: false,
        }),
    ])
}

const banners = document.querySelector('.banners');
if (banners) {
    EmblaCarousel(banners, {
        loop: true,
        align: 'start',
    }, [
        Fade({
            align: 'center',
        })
    ]);
}


const thumbnails = document.querySelector('.thumbnails');
if (thumbnails) {
    EmblaCarousel(thumbnails, {
        loop: true,
        align: 'start',
    });
}

const viewports = document.querySelector('.viewports');
if (viewports) {
    const views = EmblaCarousel(viewports, {
        loop: true,
        align: 'start',
    });

    const items = document.querySelectorAll('.thumbs');
    thumbnails.addEventListener('click', function (e) {
        const target = e.target;

        if (target.classList.contains('thumbs')) {
            const index = Array.from(items).indexOf(target);
            views.scrollTo(index, false);
        }

        e.preventDefault();
    });
}

const types = document.querySelector('.types');
if (types) {
    EmblaCarousel(types, {
        loop: true,
        align: 'start',
    });
}

