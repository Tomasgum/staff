/* ============================================================
   SCAFF THEME — MAIN JAVASCRIPT
   GSAP animations, mobile menu, header scroll
   ============================================================ */

(function () {
  'use strict';

  // ── GSAP SETUP ──────────────────────────────────────────────
  if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
    gsap.registerPlugin(ScrollTrigger);
    initGSAP();
  } else {
    // Fallback: make all animated elements visible immediately
    document.querySelectorAll('[data-animate], [data-gsap]').forEach(el => {
      el.style.opacity = '1';
      el.style.transform = 'none';
    });
  }

  // ── DOM READY ───────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initMobileMenu();
    initSmoothLinks();
    initProductCardHover();
  });


  // ════════════════════════════════════════════════════════════
  // GSAP ANIMATIONS
  // ════════════════════════════════════════════════════════════
  function initGSAP() {
    // Default eases
    const ease = 'power3.out';
    const easeBack = 'back.out(1.4)';

    // ── HERO ENTRANCE ──────────────────────────────────────────
    // CSS keyframes handle the initial fade-in (no fromTo needed).
    // GSAP cancels CSS animation and plays its own smoother version.
    const heroEyebrow = document.querySelector('[data-gsap="eyebrow"]');
    const heroTitle   = document.querySelector('[data-gsap="title"]');
    const heroSub     = document.querySelector('[data-gsap="subtitle"]');
    const heroActions = document.querySelector('[data-gsap="actions"]');
    const heroVisual  = document.querySelector('[data-gsap="visual"]');

    if (heroTitle) {
      // Stop CSS animations so GSAP takes over
      [heroEyebrow, heroTitle, heroSub, heroActions, heroVisual].forEach(el => {
        if (el) el.style.animation = 'none';
      });

      const tl = gsap.timeline({ delay: 0.05 });

      if (heroEyebrow) {
        tl.fromTo(heroEyebrow,
          { opacity: 0, x: -24 },
          { opacity: 1, x: 0, duration: 0.65, ease }
        );
      }
      tl.fromTo(heroTitle,
        { opacity: 0, y: 44, skewY: 1.5 },
        { opacity: 1, y: 0, skewY: 0, duration: 0.85, ease },
        '-=0.35'
      );
      if (heroSub) {
        tl.fromTo(heroSub,
          { opacity: 0, y: 22 },
          { opacity: 1, y: 0, duration: 0.65, ease },
          '-=0.45'
        );
      }
      if (heroActions) {
        tl.fromTo(heroActions,
          { opacity: 0, y: 18 },
          { opacity: 1, y: 0, duration: 0.55, ease },
          '-=0.35'
        );
      }
      if (heroVisual) {
        tl.fromTo(heroVisual,
          { opacity: 0, scale: 0.82, rotation: -8 },
          { opacity: 1, scale: 1, rotation: 0, duration: 0.9, ease: easeBack },
          '-=0.7'
        );
      }
    }

    // ── HERO PARALLAX ──────────────────────────────────────────
    const heroBg = document.querySelector('.hero__bg');
    if (heroBg) {
      gsap.to(heroBg, {
        yPercent: 25,
        ease: 'none',
        scrollTrigger: {
          trigger: '.hero',
          start: 'top top',
          end: 'bottom top',
          scrub: true,
        }
      });
    }

    // ── STATS BAR ──────────────────────────────────────────────
    const statItems = document.querySelectorAll('.stat-item');
    if (statItems.length) {
      gsap.fromTo(statItems,
        { opacity: 0, y: 30 },
        {
          opacity: 1, y: 0,
          duration: 0.6,
          stagger: 0.1,
          ease,
          scrollTrigger: {
            trigger: '.stats-bar',
            start: 'top 85%',
            once: true,
          }
        }
      );
    }

    // ── SCROLL REVEAL: fade-up ─────────────────────────────────
    document.querySelectorAll('[data-animate="fade-up"]').forEach(el => {
      gsap.fromTo(el,
        { opacity: 0, y: 48 },
        {
          opacity: 1, y: 0,
          duration: 0.8,
          ease,
          scrollTrigger: {
            trigger: el,
            start: 'top 88%',
            once: true,
          }
        }
      );
    });

    // ── SCROLL REVEAL: fade-right ──────────────────────────────
    document.querySelectorAll('[data-animate="fade-right"]').forEach(el => {
      gsap.fromTo(el,
        { opacity: 0, x: -50 },
        {
          opacity: 1, x: 0,
          duration: 0.9,
          ease,
          scrollTrigger: {
            trigger: el,
            start: 'top 85%',
            once: true,
          }
        }
      );
    });

    // ── SCROLL REVEAL: fade-left ───────────────────────────────
    document.querySelectorAll('[data-animate="fade-left"]').forEach(el => {
      gsap.fromTo(el,
        { opacity: 0, x: 50 },
        {
          opacity: 1, x: 0,
          duration: 0.9,
          ease,
          scrollTrigger: {
            trigger: el,
            start: 'top 85%',
            once: true,
          }
        }
      );
    });

    // ── STAGGERED CARDS ────────────────────────────────────────
    const cardGroups = new Map();
    document.querySelectorAll('[data-animate="card"]').forEach(card => {
      const parent = card.parentElement;
      if (!cardGroups.has(parent)) cardGroups.set(parent, []);
      cardGroups.get(parent).push(card);
    });

    cardGroups.forEach((cards, parent) => {
      gsap.fromTo(cards,
        { opacity: 0, y: 60, scale: 0.95 },
        {
          opacity: 1, y: 0, scale: 1,
          duration: 0.7,
          stagger: { amount: 0.5, from: 'start' },
          ease,
          scrollTrigger: {
            trigger: parent,
            start: 'top 80%',
            once: true,
          }
        }
      );
    });

    // ── USP ITEMS ──────────────────────────────────────────────
    const uspItems = document.querySelectorAll('.usp-item');
    if (uspItems.length) {
      gsap.fromTo(uspItems,
        { opacity: 0, y: 32 },
        {
          opacity: 1, y: 0,
          duration: 0.6,
          stagger: 0.12,
          ease,
          scrollTrigger: {
            trigger: '.usp-band',
            start: 'top 85%',
            once: true,
          }
        }
      );
    }

    // ── COUNTER ANIMATION ──────────────────────────────────────
    document.querySelectorAll('.stat-item__number').forEach(el => {
      const raw = el.textContent.trim();
      const target = parseInt(raw.replace(/\D/g, ''), 10);
      const suffix = raw.replace(/[0-9]/g, '');
      if (!target) return;

      ScrollTrigger.create({
        trigger: el,
        start: 'top 90%',
        once: true,
        onEnter: () => {
          gsap.fromTo({ n: 0 }, { n: target },
            {
              duration: 1.6,
              ease: 'power2.out',
              onUpdate: function () {
                el.textContent = Math.round(this.targets()[0].n) + suffix;
              }
            }
          );
        }
      });
    });

    // ── CTA BANNER PARTICLE EFFECT ────────────────────────────
    const ctaBanner = document.querySelector('.cta-banner');
    if (ctaBanner) {
      ScrollTrigger.create({
        trigger: ctaBanner,
        start: 'top 80%',
        once: true,
        onEnter: () => {
          const content = ctaBanner.querySelector('.cta-banner__content');
          if (content) {
            gsap.fromTo(content,
              { opacity: 0, y: 40, scale: 0.96 },
              { opacity: 1, y: 0, scale: 1, duration: 0.8, ease: easeBack }
            );
          }
        }
      });
    }

    // ── SECTION HEADERS ────────────────────────────────────────
    document.querySelectorAll('.section-header').forEach(header => {
      const children = header.children;
      gsap.fromTo(children,
        { opacity: 0, y: 30 },
        {
          opacity: 1, y: 0,
          duration: 0.65,
          stagger: 0.12,
          ease,
          scrollTrigger: {
            trigger: header,
            start: 'top 88%',
            once: true,
          }
        }
      );
    });

    // ── FOOTER BRAND ───────────────────────────────────────────
    const footerBrand = document.querySelector('.footer-brand');
    if (footerBrand) {
      gsap.fromTo(footerBrand,
        { opacity: 0, y: 24 },
        {
          opacity: 1, y: 0,
          duration: 0.7,
          ease,
          scrollTrigger: {
            trigger: '.footer-main',
            start: 'top 90%',
            once: true,
          }
        }
      );
    }

    // ── WOO PRODUCT CARDS (archive) ────────────────────────────
    const wooCards = document.querySelectorAll('.woocommerce ul.products li.product');
    if (wooCards.length) {
      gsap.fromTo(wooCards,
        { opacity: 0, y: 50, scale: 0.96 },
        {
          opacity: 1, y: 0, scale: 1,
          duration: 0.65,
          stagger: { amount: 0.8, from: 'start' },
          ease,
          scrollTrigger: {
            trigger: '.woocommerce ul.products',
            start: 'top 90%',
            once: true,
          }
        }
      );
    }

    // ── HORIZONTAL LINE REVEALS ────────────────────────────────
    document.querySelectorAll('.stats-bar, .usp-band, .products-section').forEach(section => {
      const line = document.createElement('div');
      line.style.cssText = `
        position:absolute;left:0;bottom:0;height:2px;
        background:var(--accent);width:0;
        pointer-events:none;
      `;
      if (getComputedStyle(section).position === 'static') {
        section.style.position = 'relative';
      }
      section.appendChild(line);

      gsap.to(line, {
        width: '100%',
        duration: 1.2,
        ease: 'power2.inOut',
        scrollTrigger: {
          trigger: section,
          start: 'top 80%',
          once: true,
        }
      });
    });
  }


  // ════════════════════════════════════════════════════════════
  // HEADER
  // ════════════════════════════════════════════════════════════
  function initHeader() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    let lastScroll = 0;
    let ticking = false;

    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          const currentScroll = window.scrollY;
          header.classList.toggle('scrolled', currentScroll > 60);
          lastScroll = currentScroll;
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }


  // ════════════════════════════════════════════════════════════
  // MOBILE MENU
  // ════════════════════════════════════════════════════════════
  function initMobileMenu() {
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuClose = document.getElementById('mobileMenuClose');
    const backdrop = document.getElementById('mobileMenuBackdrop');

    if (!hamburger || !mobileMenu) return;

    function openMenu() {
      mobileMenu.classList.add('is-open');
      backdrop.classList.add('is-visible');
      hamburger.classList.add('is-active');
      hamburger.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';

      // Stagger menu items with GSAP if available
      if (typeof gsap !== 'undefined') {
        const items = mobileMenu.querySelectorAll('.mobile-menu__list > li');
        gsap.fromTo(items,
          { opacity: 0, x: 20 },
          { opacity: 1, x: 0, duration: 0.4, stagger: 0.06, ease: 'power2.out', delay: 0.15 }
        );
      }
    }

    function closeMenu() {
      mobileMenu.classList.remove('is-open');
      backdrop.classList.remove('is-visible');
      hamburger.classList.remove('is-active');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', openMenu);
    mobileMenuClose?.addEventListener('click', closeMenu);
    backdrop.addEventListener('click', closeMenu);

    // Close on escape
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && mobileMenu.classList.contains('is-open')) closeMenu();
    });

    // Sub-menu toggle in mobile
    const hasChildren = mobileMenu.querySelectorAll('.menu-item-has-children');
    hasChildren.forEach(item => {
      const link = item.querySelector('a');
      const sub = item.querySelector('.sub-menu');
      if (!sub) return;

      const toggle = document.createElement('button');
      toggle.className = 'mobile-submenu-toggle';
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Toggle submenu');
      toggle.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>';
      toggle.style.cssText = 'float:right;width:32px;height:32px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);transition:transform 0.25s;';
      link.parentNode.insertBefore(toggle, link.nextSibling);

      sub.style.display = 'none';

      toggle.addEventListener('click', e => {
        e.preventDefault();
        const isOpen = sub.style.display !== 'none';
        sub.style.display = isOpen ? 'none' : 'block';
        toggle.style.transform = isOpen ? '' : 'rotate(180deg)';
        toggle.setAttribute('aria-expanded', String(!isOpen));
      });
    });
  }


  // ════════════════════════════════════════════════════════════
  // SMOOTH SCROLL
  // ════════════════════════════════════════════════════════════
  function initSmoothLinks() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
      link.addEventListener('click', e => {
        const target = document.querySelector(link.getAttribute('href'));
        if (!target) return;
        e.preventDefault();

        const headerH = document.querySelector('.site-header')?.offsetHeight ?? 72;
        const top = target.getBoundingClientRect().top + window.scrollY - headerH - 24;

        if (typeof gsap !== 'undefined') {
          gsap.to(window, { scrollTo: top, duration: 1, ease: 'power3.inOut' });
        } else {
          window.scrollTo({ top, behavior: 'smooth' });
        }
      });
    });
  }


  // ════════════════════════════════════════════════════════════
  // PRODUCT CARD HOVER (magnetic arrow)
  // ════════════════════════════════════════════════════════════
  function initProductCardHover() {
    if (typeof gsap === 'undefined') return;

    document.querySelectorAll('.category-card').forEach(card => {
      const arrow = card.querySelector('.category-card__arrow');
      if (!arrow) return;

      card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        gsap.to(arrow, {
          x: x * 0.08,
          y: y * 0.08,
          duration: 0.4,
          ease: 'power2.out',
        });
      });

      card.addEventListener('mouseleave', () => {
        gsap.to(arrow, { x: 0, y: 0, duration: 0.5, ease: 'elastic.out(1, 0.5)' });
      });
    });
  }

})();
