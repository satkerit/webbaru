/**
 * BPRS Bangka Belitung - Admin JavaScript
 */

(function () {
  "use strict";

  // =====================================================
  // Auto-dismiss alerts
  // =====================================================
  function initAutoDismiss() {
    document.querySelectorAll("[data-auto-dismiss]").forEach(function (el) {
      const delay = parseInt(el.dataset.autoDismiss, 10) || 4000;
      setTimeout(function () {
        el.style.transition = "opacity 0.4s ease, max-height 0.4s ease";
        el.style.opacity = "0";
        el.style.maxHeight = "0";
        el.style.overflow = "hidden";
        el.style.marginBottom = "0";
        setTimeout(function () {
          el.remove();
        }, 450);
      }, delay);
    });
  }

  // =====================================================
  // Confirm delete
  // =====================================================
  function initConfirmDelete() {
    document.addEventListener("click", function (e) {
      const btn = e.target.closest("[data-confirm-delete]");
      if (!btn) return;
      e.preventDefault();
      const msg =
        btn.dataset.confirmDelete ||
        "Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.";
      if (!confirm(msg)) return;
      // If it's a link, follow it
      if (btn.tagName === "A") {
        window.location.href = btn.href;
      } else if (btn.tagName === "BUTTON") {
        // Submit parent form
        const form = btn.closest("form");
        if (form) form.submit();
      }
    });
  }

  // =====================================================
  // AJAX Status Toggle (active/inactive switches)
  // =====================================================
  function initStatusToggle() {
    document.addEventListener("change", function (e) {
      const toggle = e.target.closest("[data-toggle-status]");
      if (!toggle) return;

      const url = toggle.dataset.toggleStatus;
      const itemId = toggle.dataset.id;
      const field = toggle.dataset.field || "is_active";
      const value = toggle.checked ? "1" : "0";

      if (!url) return;

      // Optimistic update
      const label = document.querySelector(`[data-toggle-label="${itemId}"]`);
      if (label) label.textContent = toggle.checked ? "Aktif" : "Nonaktif";

      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        body: JSON.stringify({ [field]: value }),
      })
        .then(function (res) {
          return res.json();
        })
        .then(function (data) {
          if (data.success) {
            showToast(data.message || "Status berhasil diperbarui", "success");
          } else {
            // Revert toggle on error
            toggle.checked = !toggle.checked;
            if (label)
              label.textContent = toggle.checked ? "Aktif" : "Nonaktif";
            showToast(data.message || "Gagal memperbarui status", "error");
          }
        })
        .catch(function () {
          toggle.checked = !toggle.checked;
          if (label) label.textContent = toggle.checked ? "Aktif" : "Nonaktif";
          showToast("Terjadi kesalahan jaringan", "error");
        });
    });
  }

  // =====================================================
  // Toast Notification helper
  // =====================================================
  function showToast(message, type) {
    type = type || "info";
    const colors = {
      success: "bg-green-50 border-green-200 text-green-700",
      error: "bg-red-50 border-red-200 text-red-700",
      info: "bg-blue-50 border-blue-200 text-blue-700",
      warning: "bg-yellow-50 border-yellow-200 text-yellow-700",
    };
    const icons = {
      success: "fa-check-circle",
      error: "fa-exclamation-circle",
      info: "fa-info-circle",
      warning: "fa-exclamation-triangle",
    };

    const toast = document.createElement("div");
    toast.className =
      "fixed bottom-5 right-5 z-[9999] flex items-center gap-3 px-4 py-3 rounded-xl border shadow-xl text-sm max-w-sm " +
      (colors[type] || colors.info);
    toast.innerHTML =
      '<i class="fas ' +
      (icons[type] || "fa-info-circle") +
      ' flex-shrink-0"></i><span>' +
      message +
      "</span>";
    toast.style.transform = "translateY(20px)";
    toast.style.opacity = "0";
    toast.style.transition = "all 0.3s ease";

    document.body.appendChild(toast);

    requestAnimationFrame(function () {
      toast.style.transform = "translateY(0)";
      toast.style.opacity = "1";
    });

    setTimeout(function () {
      toast.style.opacity = "0";
      toast.style.transform = "translateY(20px)";
      setTimeout(function () {
        toast.remove();
      }, 350);
    }, 3500);
  }

  // Expose globally for inline use
  window.showToast = showToast;

  // =====================================================
  // Init all
  // =====================================================
  document.addEventListener("DOMContentLoaded", function () {
    initAutoDismiss();
    initConfirmDelete();
    initStatusToggle();
  });
})();
