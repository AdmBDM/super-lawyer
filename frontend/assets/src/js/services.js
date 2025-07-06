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
