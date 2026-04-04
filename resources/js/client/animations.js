/**
 * Client-side Scroll Animations & Interactivity
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Core Scroll Reveal Observer
    const revealCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                // Unobserve if you only want it to happen once
                // observer.unobserve(entry.target);
            } else {
                // If you want it to trigger every time it comes back into view, remove comment:
                // entry.target.classList.remove('active');
            }
        });
    };

    const revealObserver = new IntersectionObserver(revealCallback, {
        root: null, // use viewport
        rootMargin: '0px',
        threshold: 0.15 // trigger when 15% of element is visible
    });

    // Observe all elements with .reveal class
    const revealElements = document.querySelectorAll('.reveal');
    revealElements.forEach(el => revealObserver.observe(el));


    // 2. Automated Staggering for Grids
    // If a class has .stagger-reveal, automatically add delays to its children
    const gridContainers = document.querySelectorAll('.amenities-grid, .stays-grid, .amenities-list');
    gridContainers.forEach(container => {
        const children = container.children;
        Array.from(children).forEach((child, index) => {
            child.classList.add('reveal', 'reveal-up');
            child.style.transitionDelay = `${(index % 4) * 0.15}s`;
            revealObserver.observe(child);
        });
    });

    // 3. Hero Entry Animations (Immediate, not on scroll)
    const heroTitle = document.querySelector('.hero-title');
    const heroDesc = document.querySelector('.hero-description');
    const heroBadge = document.querySelector('.hero-badge');
    const bookingWidget = document.querySelector('.booking-widget');

    if (heroTitle) {
        heroTitle.style.opacity = '0';
        heroTitle.style.transform = 'translateY(20px)';
        heroTitle.classList.add('animate-fade-up');
        heroTitle.style.animationDelay = '0.3s';
    }

    if (heroBadge) {
        heroBadge.style.opacity = '0';
        heroBadge.style.transform = 'translateY(10px)';
        heroBadge.classList.add('animate-fade-up');
        heroBadge.style.animationDelay = '0.1s';
    }

    if (heroDesc) {
        heroDesc.style.opacity = '0';
        heroDesc.style.transform = 'translateY(20px)';
        heroDesc.classList.add('animate-fade-up');
        heroDesc.style.animationDelay = '0.5s';
    }

    if (bookingWidget) {
        bookingWidget.style.opacity = '0';
        bookingWidget.classList.add('animate-fade-up');
        bookingWidget.style.animationPosition = 'bottom';
        bookingWidget.style.animationDelay = '0.7s';
    }

    // 4. Parallax Effect for Hero Image (Optional but Premium)
    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        const hero = document.querySelector('.hero');
        if (hero) {
            hero.style.backgroundPositionY = `${scrolled * 0.5}px`;
        }
    });
});
