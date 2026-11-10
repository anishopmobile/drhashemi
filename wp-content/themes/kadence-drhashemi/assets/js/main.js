/**
 * رفتارهای تعاملی سایت دکتر سید احمد هاشمی.
 *
 * مستقل از کتابخانه است، در انتهای صفحه با defer بارگذاری می‌شود و در صورت
 * نبود هر عنصر بی‌صدا خارج می‌شود.
 *
 * @package kadence-drhashemi
 */
(function () {
	'use strict';

	var doc = document;
	var root = doc.documentElement;
	var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
	var FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

	root.classList.remove('no-js');
	root.classList.add('js');

	/* ---------------------------------------------------------- منوی موبایل */
	var drawer = doc.getElementById('drh-drawer');
	var menuToggle = doc.getElementById('drh-menu-toggle');

	if (drawer && menuToggle) {
		var panel = drawer.querySelector('.drh-drawer__panel');
		var lastFocused = null;

		var isOpen = function () {
			return drawer.getAttribute('data-state') === 'open';
		};

		var openDrawer = function () {
			lastFocused = doc.activeElement;
			drawer.setAttribute('data-state', 'open');
			drawer.removeAttribute('aria-hidden');
			drawer.removeAttribute('inert');
			menuToggle.setAttribute('aria-expanded', 'true');
			doc.body.classList.add('is-drawer-open');

			if (panel) {
				var first = panel.querySelector(FOCUSABLE);
				if (first) {
					window.setTimeout(function () {
						first.focus();
					}, 40);
				}
			}
		};

		var closeDrawer = function (restoreFocus) {
			if (!isOpen()) {
				return;
			}
			drawer.setAttribute('data-state', 'closed');
			drawer.setAttribute('aria-hidden', 'true');
			drawer.setAttribute('inert', '');
			menuToggle.setAttribute('aria-expanded', 'false');
			doc.body.classList.remove('is-drawer-open');

			if (restoreFocus !== false && lastFocused && typeof lastFocused.focus === 'function') {
				lastFocused.focus();
			}
		};

		menuToggle.addEventListener('click', function () {
			if (isOpen()) {
				closeDrawer();
			} else {
				openDrawer();
			}
		});

		drawer.querySelectorAll('[data-drh-close]').forEach(function (button) {
			button.addEventListener('click', function () {
				closeDrawer();
			});
		});

		drawer.querySelectorAll('.drh-drawer__nav a').forEach(function (link) {
			link.addEventListener('click', function () {
				closeDrawer(false);
			});
		});

		doc.addEventListener('keydown', function (event) {
			if (!isOpen()) {
				return;
			}

			if (event.key === 'Escape') {
				event.preventDefault();
				closeDrawer();
				return;
			}

			if (event.key !== 'Tab' || !panel) {
				return;
			}

			var items = Array.prototype.filter.call(
				panel.querySelectorAll(FOCUSABLE),
				function (item) {
					return item.offsetParent !== null;
				}
			);

			if (!items.length) {
				return;
			}

			var first = items[0];
			var last = items[items.length - 1];

			if (event.shiftKey && doc.activeElement === first) {
				event.preventDefault();
				last.focus();
			} else if (!event.shiftKey && doc.activeElement === last) {
				event.preventDefault();
				first.focus();
			}
		});

		window.addEventListener('resize', function () {
			if (window.innerWidth >= 1024 && isOpen()) {
				closeDrawer(false);
			}
		});
	}

	/* -------------------------------------------------------------- جست‌وجو */
	var searchToggle = doc.getElementById('drh-search-toggle');
	var searchPanel = doc.getElementById('drh-search-panel');

	if (searchToggle && searchPanel) {
		var closeSearch = function () {
			searchPanel.hidden = true;
			searchToggle.setAttribute('aria-expanded', 'false');
		};

		searchToggle.addEventListener('click', function () {
			var opening = searchPanel.hidden;
			searchPanel.hidden = !opening;
			searchToggle.setAttribute('aria-expanded', opening ? 'true' : 'false');

			if (opening) {
				var input = searchPanel.querySelector('input[type="search"]');
				if (input) {
					window.setTimeout(function () {
						input.focus();
					}, 30);
				}
			}
		});

		doc.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && !searchPanel.hidden) {
				closeSearch();
				searchToggle.focus();
			}
		});
	}

	/* ------------------------------------------------------- حالت اسکرول */
	var header = doc.getElementById('masthead');
	if (header) {
		var onScroll = function () {
			header.classList.toggle('is-scrolled', window.scrollY > 8);
		};
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	/* -------------------------------------------- تصاویر شکستهٔ محتوای قدیمی */
	var hideBroken = function (image) {
		if (image.classList.contains('drh-portrait__img')) {
			return;
		}
		image.classList.add('is-broken');
	};

	doc.querySelectorAll('.drh-prose img, .wp-caption img').forEach(function (image) {
		if (image.complete && image.naturalWidth === 0) {
			hideBroken(image);
			return;
		}
		image.addEventListener('error', function () {
			hideBroken(image);
		});
	});

	/* ----------------------------------------------- احترام به کاهش حرکت */
	if (reducedMotion && typeof reducedMotion.addEventListener === 'function') {
		reducedMotion.addEventListener('change', function () {
			root.classList.toggle('drh-reduced-motion', reducedMotion.matches);
		});
	}
})();
