const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
if (!reduce) document.documentElement.classList.add('motion');

const navBtn = document.querySelector('.menu-btn');
const nav = document.getElementById('site-nav');
navBtn?.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    navBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
});
nav?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
        nav.classList.remove('open');
        navBtn?.setAttribute('aria-expanded', 'false');
    });
});

const sections = [...document.querySelectorAll('main section[id]')];
const links = [...document.querySelectorAll('#site-nav a')];
if (sections.length && links.length) {
    const spy = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            links.forEach((link) => {
                const on = link.getAttribute('href')?.endsWith('#' + entry.target.id);
                link.toggleAttribute('aria-current', Boolean(on));
                if (!on) link.removeAttribute('aria-current');
            });
        });
    }, { rootMargin: '-45% 0px -50% 0px' });
    sections.forEach((section) => spy.observe(section));
}

const bar = document.getElementById('read-progress');
const onScroll = () => {
    if (!bar) return;
    const height = document.documentElement.scrollHeight - window.innerHeight;
    bar.style.width = height > 0 ? `${(window.scrollY / height) * 100}%` : '0';
};
document.addEventListener('scroll', onScroll, { passive: true });
onScroll();

document.querySelectorAll('[data-tab]').forEach((button) => {
    button.addEventListener('click', () => {
        const id = button.dataset.tab;
        document.querySelectorAll('[data-tab]').forEach((item) => {
            const selected = item === button;
            item.setAttribute('aria-selected', selected ? 'true' : 'false');
            item.tabIndex = selected ? 0 : -1;
        });
        document.querySelectorAll('[data-panel]').forEach((panel) => {
            panel.hidden = panel.dataset.panel !== id;
        });
    });
});

const marquee = document.querySelector('[data-marquee]');
const marqueeBtn = document.querySelector('[data-marquee-toggle]');
if (reduce && marquee) marquee.classList.add('is-paused');
marqueeBtn?.addEventListener('click', () => {
    const paused = marquee.classList.toggle('is-paused');
    marqueeBtn.setAttribute('aria-pressed', paused ? 'true' : 'false');
    marqueeBtn.textContent = paused ? 'Putar' : 'Jeda';
});

const canvas = document.getElementById('net');
if (canvas && !reduce) {
    const ctx = canvas.getContext('2d');
    let nodes = [];
    let width = 0;
    let height = 0;
    let running = true;
    const resize = () => {
        const ratio = Math.min(window.devicePixelRatio || 1, 2);
        width = canvas.width = Math.floor(canvas.offsetWidth * ratio);
        height = canvas.height = Math.floor(canvas.offsetHeight * ratio);
        const count = window.innerWidth < 768 ? 28 : 56;
        nodes = Array.from({ length: count }, () => ({
            x: Math.random() * width,
            y: Math.random() * height,
            vx: (Math.random() - 0.5) * 0.35,
            vy: (Math.random() - 0.5) * 0.35,
        }));
    };
    const frame = () => {
        if (!running) return;
        ctx.clearRect(0, 0, width, height);
        const reach = 150 * (window.devicePixelRatio || 1);
        nodes.forEach((node) => {
            node.x += node.vx;
            node.y += node.vy;
            if (node.x < 0 || node.x > width) node.vx *= -1;
            if (node.y < 0 || node.y > height) node.vy *= -1;
        });
        for (let i = 0; i < nodes.length; i++) {
            for (let j = i + 1; j < nodes.length; j++) {
                const a = nodes[i];
                const b = nodes[j];
                const dist = Math.hypot(a.x - b.x, a.y - b.y);
                if (dist < reach) {
                    ctx.strokeStyle = `rgba(74,222,128,${(1 - dist / reach) * 0.35})`;
                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                    ctx.stroke();
                }
            }
        }
        ctx.fillStyle = '#bbf7d0';
        nodes.forEach((node) => {
            ctx.beginPath();
            ctx.arc(node.x, node.y, 1.6, 0, Math.PI * 2);
            ctx.fill();
        });
        requestAnimationFrame(frame);
    };
    resize();
    window.addEventListener('resize', resize);
    document.addEventListener('visibilitychange', () => {
        running = !document.hidden;
        if (running) frame();
    });
    frame();
}

const fab = document.querySelector('.wa-fab');
const panel = document.getElementById('wa-panel');
fab?.addEventListener('click', () => {
    const open = panel.hasAttribute('hidden');
    panel.toggleAttribute('hidden', !open);
    fab.setAttribute('aria-expanded', open ? 'true' : 'false');
});

document.querySelector('[data-preview-toggle]')?.addEventListener('click', (event) => {
    const button = event.currentTarget;
    const frame = document.querySelector('.preview iframe');
    const still = document.querySelector('.preview-still');
    const showStill = button.getAttribute('aria-pressed') !== 'true';
    button.setAttribute('aria-pressed', showStill ? 'true' : 'false');
    button.textContent = showStill ? 'Lihat live' : 'Lihat gambar';
    frame?.classList.toggle('is-hidden', showStill);
    still?.classList.toggle('is-hidden', !showStill);
});

const dialog = document.getElementById('lightbox');
document.querySelectorAll('[data-lightbox]').forEach((button) => {
    button.addEventListener('click', () => {
        const image = dialog.querySelector('img');
        image.src = button.dataset.lightbox;
        image.alt = button.querySelector('img')?.alt || 'Galeri';
        dialog.showModal();
    });
});

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const hangs = [...document.querySelectorAll('.hang')];
const flipCard = (card) => {
    const flipped = card.classList.toggle('is-flipped');
    card.setAttribute('aria-pressed', flipped ? 'true' : 'false');
};

const bindKeys = (card) => {
    card.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            flipCard(card);
        }
    });
};

if (!hangs.length || reduceMotion) {
    document.querySelectorAll('[data-badge]').forEach((card) => {
        bindKeys(card);
        card.addEventListener('click', (event) => {
            if (!event.target.closest('a')) {
                flipCard(card);
            }
        });
    });
} else {
    const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
    const bodies = hangs.map((el, index) => ({
        el,
        badge: el.querySelector('[data-badge]'),
        angle: (index % 2 === 0 ? -1 : 1) * 0.06,
        velocity: 0,
        pull: 0,
        pullV: 0,
        dragging: false,
        pointer: null,
        pin: null,
        moved: 0,
    }));

    const paint = (body) => {
        const deg = body.angle * (180 / Math.PI);
        body.el.style.transform = `rotateZ(${deg.toFixed(2)}deg)`;
        body.el.style.setProperty('--pull', `${Math.max(0, body.pull).toFixed(1)}px`);
        body.el.style.setProperty('--stretch', (1 + Math.max(0, body.pull) / 48).toFixed(3));
    };

    const pinOf = (el) => {
        const previous = el.style.transform;
        el.style.transform = 'none';
        const rect = el.getBoundingClientRect();
        el.style.transform = previous;
        return { x: rect.left + rect.width / 2, y: rect.top + 8 };
    };

    bodies.forEach((body) => {
        bindKeys(body.badge);
        const start = (event) => {
            if (event.button !== 0 || event.target.closest('a')) {
                return;
            }
            event.preventDefault();
            body.dragging = true;
            body.pointer = event.pointerId;
            body.pin = pinOf(body.el);
            body.moved = 0;
            body.startX = event.clientX;
            body.startY = event.clientY;
            body.grabAngle = body.angle;
            body.grabPull = body.pull;
            body.el.classList.add('is-dragging');
            try {
                body.badge.setPointerCapture(event.pointerId);
            } catch (error) {
                /* Pointer sintetis atau yang sudah lepas tidak bisa ditangkap. */
            }
        };
        const move = (event) => {
            if (!body.dragging || event.pointerId !== body.pointer) {
                return;
            }
            const dx = event.clientX - body.startX;
            const dy = event.clientY - body.startY;
            body.moved = Math.max(body.moved, Math.hypot(dx, dy));
            body.angle = clamp(body.grabAngle - dx / 160, -0.7, 0.7);
            body.pull = clamp(body.grabPull + dy, 0, 90);
            body.velocity = clamp(dx / 160 - (body.angle - body.grabAngle), -0.12, 0.12);
            body.pullV = clamp(dy / 8, -8, 8);
            paint(body);
        };
        const release = (event) => {
            if (!body.dragging || event.pointerId !== body.pointer) {
                return;
            }
            body.dragging = false;
            body.el.classList.remove('is-dragging');
            if (body.moved < 8) {
                body.velocity = 0;
                body.pullV = 0;
                flipCard(body.badge);
            }
        };
        body.badge.addEventListener('pointerdown', start);
        body.badge.addEventListener('pointermove', move);
        body.badge.addEventListener('pointerup', release);
        body.badge.addEventListener('pointercancel', release);
    });

    const step = (now) => {
        bodies.forEach((body, index) => {
            if (!body.dragging) {
                const rest = Math.sin(now / 1400 + index) * 0.05;
                body.velocity += (rest - body.angle) * 0.14;
                body.velocity *= 0.82;
                body.angle = clamp(body.angle + body.velocity, -0.7, 0.7);
                body.pullV += (0 - body.pull) * 0.2;
                body.pullV *= 0.62;
                body.pull = Math.max(0, body.pull + body.pullV);
                paint(body);
            }
        });
        requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
}

const errors = document.getElementById('form-errors');
if (errors) {
    errors.focus();
    document.getElementById('kontak')?.scrollIntoView();
}
