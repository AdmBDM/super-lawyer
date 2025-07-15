document.addEventListener("DOMContentLoaded", function () {
	const burger = document.querySelector('.burger');
	const nav = document.querySelector('.nav-links');
	const citySelect = document.getElementById('citySelectNav');
	const btnService = document.getElementById('toggleServicesBtn');
	const btnCities = document.getElementById('toggleCitiesBtn');
	const elements = document.querySelectorAll('.fade-in');

	let collapseTimeout = 350;
	let txtClose = 'Скрыть ';
	let txtOpen = 'Показать все ';
	let txtService = 'услуги';
	let txtCity = 'города';

	elements.forEach((el, index) => {
		el.style.animationDelay = `${index * 0.2}s`;
	});

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

	if (btnService) {
		btnService.addEventListener('click', () => {
			// ждём окончания bootstrap‑анимации collapse (350 мс по‑умолчанию)
			setTimeout(() => {
				const expanded = btnService.getAttribute('aria-expanded') === 'true';
				btnService.textContent = expanded ? txtClose + txtService : txtOpen + txtService;
			}, collapseTimeout);
		});
	}

	if (btnCities) {
		btnCities.addEventListener('click', () => {
			setTimeout(() => {
				const expanded = btnCities.getAttribute('aria-expanded') === 'true';
				btn.textContent = expanded ? txtClose + txtCity : txtOpen + txtCity;
			}, collapseTimeout);
		});
	}

});
