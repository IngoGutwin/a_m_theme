import "@styles/main.css";
import "./lib/navbar.utils";

function debugg_vite() {
	if (import.meta.hot) {
		import.meta.hot.on('vite:beforeUpdate', (p) => console.log('[HMR before]', p));
		import.meta.hot.on('vite:afterUpdate', (p) => console.log('[HMR after]', p));
		import.meta.hot.on('vite:error', (e) => console.error('[HMR error]', e));
		import.meta.hot.on('vite:invalidate', (p) => console.warn('[HMR invalidate]', p));
	}
}

function init() {
	debugg_vite();
}

window.addEventListener("DOMContentLoaded", init);
