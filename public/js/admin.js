document.querySelector('[data-admin-nav]')?.addEventListener('click', (event) => {
    const side = document.getElementById('admin-nav');
    const open = side.classList.toggle('open');
    event.currentTarget.setAttribute('aria-expanded', open ? 'true' : 'false');
});
