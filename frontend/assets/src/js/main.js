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

document.addEventListener('DOMContentLoaded', () => {
	const btn = document.getElementById('toggleServicesBtn');
	if (!btn) return;

	btn.addEventListener('click', () => {
		// ждём окончания bootstrap‑анимации collapse (350 мс по‑умолчанию)
		setTimeout(() => {
			const expanded = btn.getAttribute('aria-expanded') === 'true';
			btn.textContent = expanded ? 'Скрыть услуги' : 'Показать все услуги';
		}, 350);
	});
});
