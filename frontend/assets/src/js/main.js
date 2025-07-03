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

			// Сохраняем в cookie на 30 дней
			// document.cookie = `city=${encodeURIComponent(selectedCity)}; path=/; max-age=${30 * 24 * 60 * 60}`;

			// ↙️  убираем encodeURIComponent
			document.cookie = `city=${slug}; path=/; max-age=${30*24*60*60}; SameSite=Lax`;

			// Обновляем страницу
			location.reload();
		});
	}

});
