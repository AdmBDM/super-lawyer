import './services';

document.addEventListener("DOMContentLoaded", function () {
	const burger = document.querySelector('.burger');
	const nav = document.querySelector('.nav-links');
	const citySelect = document.getElementById('citySelectNav');

	if (burger && nav) {
		burger.addEventListener('click', () => {
			nav.classList.toggle('active');
		});
	}

	if (citySelect) {
		citySelect.addEventListener('change', function () {
			const slug = this.value;
			// Переход на action, который установит cookie
			window.location.href = `/site/set-city?slug=${slug}`;
		});
	}

});
