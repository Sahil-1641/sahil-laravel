const mobileMenu = document.querySelector('[data-mobile-menu]');
const mobileViewport = window.matchMedia('(max-width: 640px)');

const syncNavigation = () => {
	if (mobileMenu) {
		mobileMenu.open = !mobileViewport.matches;
	}
};

syncNavigation();
mobileViewport.addEventListener('change', syncNavigation);

mobileMenu?.querySelectorAll('a').forEach((link) => {
	link.addEventListener('click', () => {
		mobileMenu.open = false;
	});
});
