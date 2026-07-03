/**
 * BPRS Bangka Belitung - Main JavaScript
 */

"use strict";

// ============================================================
// HERO SLIDER
// ============================================================
class HeroSlider {
  constructor(el) {
    this.el = el;
    this.slides = [...el.querySelectorAll(".hero-slide")];
    this.dots = [...el.querySelectorAll(".slider-dot")];
    this.current = 0;
    this.total = this.slides.length;
    this.interval = null;
    this.delay = 5000;

    if (this.total < 2) return;
    this.init();
  }

  init() {
    this.goTo(0);
    this.start();

    // Prev/Next buttons
    this.el
      .querySelector("[data-slider-prev]")
      ?.addEventListener("click", () => {
        this.prev();
        this.restart();
      });
    this.el
      .querySelector("[data-slider-next]")
      ?.addEventListener("click", () => {
        this.next();
        this.restart();
      });

    // Dot navigation
    this.dots.forEach((dot, i) => {
      dot.addEventListener("click", () => {
        this.goTo(i);
        this.restart();
      });
    });

    // Pause on hover
    this.el.addEventListener("mouseenter", () => this.stop());
    this.el.addEventListener("mouseleave", () => this.start());

    // Swipe support (touch)
    let startX = 0;
    this.el.addEventListener(
      "touchstart",
      (e) => {
        startX = e.touches[0].clientX;
      },
      { passive: true },
    );
    this.el.addEventListener("touchend", (e) => {
      const diff = startX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 50) {
        diff > 0 ? this.next() : this.prev();
        this.restart();
      }
    });
  }

  goTo(index) {
    this.slides[this.current]?.classList.remove("active");
    this.dots[this.current]?.classList.remove("active");
    this.current = (index + this.total) % this.total;
    this.slides[this.current]?.classList.add("active");
    this.dots[this.current]?.classList.add("active");

    // Animate text
    const textEls =
      this.slides[this.current].querySelectorAll(".animate-fade-up");
    textEls.forEach((el) => {
      el.style.animation = "none";
      el.offsetHeight;
      el.style.animation = "";
    });
  }

  next() {
    this.goTo(this.current + 1);
  }
  prev() {
    this.goTo(this.current - 1);
  }
  start() {
    this.interval = setInterval(() => this.next(), this.delay);
  }
  stop() {
    clearInterval(this.interval);
  }
  restart() {
    this.stop();
    this.start();
  }
}

// ============================================================
// ACCORDION (FAQ)
// ============================================================
function initAccordions() {
  document.querySelectorAll(".accordion-header").forEach((header) => {
    header.addEventListener("click", () => {
      const item = header.closest(".accordion-item");
      const isOpen = item.classList.contains("open");

      // Close all
      document
        .querySelectorAll(".accordion-item.open")
        .forEach((i) => i.classList.remove("open"));

      // Open clicked (if was closed)
      if (!isOpen) item.classList.add("open");
    });
  });
}

// ============================================================
// TABS
// ============================================================
function initTabs() {
  document.querySelectorAll("[data-tab-group]").forEach((group) => {
    const buttons = group.querySelectorAll("[data-tab]");
    const panels = document.querySelectorAll(
      `[data-tab-panel="${group.dataset.tabGroup}"]`,
    );

    buttons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const target = btn.dataset.tab;

        // Update buttons
        buttons.forEach((b) =>
          b.classList.toggle("active", b.dataset.tab === target),
        );

        // Update panels
        panels.forEach((p) => {
          p.hidden =
            p.dataset.tabPanel !== group.dataset.tabGroup ||
            p.dataset.tab !== target;
          if (!p.hidden && p.dataset.tab === target) p.hidden = false;
        });

        // Actually show matching panel
        document
          .querySelectorAll(`[data-tab="${target}"][data-tab-panel]`)
          .forEach((p) => (p.hidden = false));
      });
    });
  });
}

// ============================================================
// BACK TO TOP
// ============================================================
function initBackToTop() {
  const btn = document.getElementById("backToTop");
  if (!btn) return;

  window.addEventListener(
    "scroll",
    () => {
      btn.classList.toggle("hidden", window.scrollY < 400);
      btn.classList.toggle("flex", window.scrollY >= 400);
    },
    { passive: true },
  );
}

// ============================================================
// LAZY LOADING IMAGES
// ============================================================
function initLazyImages() {
  if ("IntersectionObserver" in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) {
              img.src = img.dataset.src;
              img.addEventListener("load", () => img.classList.add("loaded"), {
                once: true,
              });
            }
            observer.unobserve(img);
          }
        });
      },
      { rootMargin: "200px" },
    );

    document
      .querySelectorAll("img.lazy")
      .forEach((img) => observer.observe(img));
  } else {
    // Fallback: load all immediately
    document.querySelectorAll("img.lazy").forEach((img) => {
      if (img.dataset.src) img.src = img.dataset.src;
      img.classList.add("loaded");
    });
  }
}

// ============================================================
// COUNTER ANIMATION
// ============================================================
function animateCounter(el) {
  const target = parseInt(
    el.dataset.target || el.textContent.replace(/\D/g, ""),
    10,
  );
  const suffix = el.dataset.suffix || "";
  const duration = 1500;
  const step = target / (duration / 16);
  let current = 0;

  const timer = setInterval(() => {
    current += step;
    if (current >= target) {
      current = target;
      clearInterval(timer);
    }
    el.textContent = Math.floor(current).toLocaleString("id-ID") + suffix;
  }, 16);
}

function initCounters() {
  if (!("IntersectionObserver" in window)) return;
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.5 },
  );
  document
    .querySelectorAll("[data-counter]")
    .forEach((el) => observer.observe(el));
}

// ============================================================
// FLASH MESSAGE AUTO-DISMISS
// ============================================================
function initFlashMessages() {
  document.querySelectorAll("[data-flash]").forEach((el) => {
    setTimeout(() => {
      el.style.transition = "opacity .4s, transform .4s";
      el.style.opacity = "0";
      el.style.transform = "translateY(-8px)";
      setTimeout(() => el.remove(), 400);
    }, 5000);

    // Close button
    el.querySelector("[data-flash-close]")?.addEventListener("click", () =>
      el.remove(),
    );
  });
}

// ============================================================
// FORM VALIDATION (basic client-side)
// ============================================================
function initForms() {
  document.querySelectorAll("form[data-validate]").forEach((form) => {
    form.addEventListener("submit", function (e) {
      let valid = true;
      const required = form.querySelectorAll("[required]");

      required.forEach((field) => {
        const errorEl = form.querySelector(`[data-error="${field.name}"]`);
        if (!field.value.trim()) {
          valid = false;
          field.classList.add("border-red-400");
          if (errorEl) errorEl.textContent = "Field ini wajib diisi.";
        } else {
          field.classList.remove("border-red-400");
          if (errorEl) errorEl.textContent = "";
        }

        // Email validation
        if (
          field.type === "email" &&
          field.value &&
          !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)
        ) {
          valid = false;
          field.classList.add("border-red-400");
          if (errorEl) errorEl.textContent = "Format email tidak valid.";
        }
      });

      if (!valid) e.preventDefault();
    });

    // Remove error on input
    form.querySelectorAll("[required]").forEach((field) => {
      field.addEventListener("input", () => {
        field.classList.remove("border-red-400");
        const errorEl = form.querySelector(`[data-error="${field.name}"]`);
        if (errorEl) errorEl.textContent = "";
      });
    });
  });
}

// ============================================================
// SCROLL REVEAL (simple)
// ============================================================
function initScrollReveal() {
  if (!("IntersectionObserver" in window)) return;
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("fade-in");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.1, rootMargin: "0px 0px -40px 0px" },
  );

  document
    .querySelectorAll("[data-reveal]")
    .forEach((el) => observer.observe(el));
}

// ============================================================
// STICKY HEADER SHADOW
// ============================================================
function initStickyHeader() {
  const header = document.querySelector("header");
  if (!header) return;
  window.addEventListener(
    "scroll",
    () => {
      header.classList.toggle("shadow-md", window.scrollY > 10);
    },
    { passive: true },
  );
}

// ============================================================
// INIT ALL
// ============================================================
document.addEventListener("DOMContentLoaded", () => {
  // Hero slider
  document
    .querySelectorAll("[data-hero-slider]")
    .forEach((el) => new HeroSlider(el));

  // UI components
  initAccordions();
  initTabs();
  initBackToTop();
  initLazyImages();
  initCounters();
  initFlashMessages();
  initForms();
  initScrollReveal();
  initStickyHeader();
});
