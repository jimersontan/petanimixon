// This login.js will use runtime routes provided by the blade template via window.routes
// Basic behavior: validate and POST to window.routes.loginSubmit

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.querySelector('.toggle-password');
    if (!passwordInput) return;
    if (passwordInput.type === 'password') { passwordInput.type = 'text'; toggleBtn && toggleBtn.classList.add('active'); }
    else { passwordInput.type = 'password'; toggleBtn && toggleBtn.classList.remove('active'); }
}

function isValidEmail(email) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email); }
function showError(id, msg) { const el = document.getElementById(id); if (el) el.textContent = msg; }

const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        let ok = true;
        showError('emailError', ''); showError('passwordError', '');
        if (!email || !isValidEmail(email)) { showError('emailError', 'Please enter a valid email'); ok = false; }
        if (!password) { showError('passwordError', 'Password is required'); ok = false; }
        if (!ok) return;
        const btn = loginForm.querySelector('.login-btn'); const orig = btn.innerHTML; btn.disabled = true; btn.classList.add('loading'); btn.textContent = 'Logging in...';
        try {
            const token = document.querySelector('input[name="_token"]').value;
            const data = new URLSearchParams(new FormData(loginForm));
            const res = await fetch(window.routes.loginSubmit || '/login', { method: 'POST', headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }, body: data });
            const json = await res.json();
            if (res.ok && json.success) {
                btn.textContent = '✓ Login Successful!';
                setTimeout(() => window.location.href = json.redirect || '/', 800);
            } else {
                showError('emailError', json.message || 'Login failed'); btn.disabled = false; btn.classList.remove('loading'); btn.innerHTML = orig;
            }
        } catch (err) { console.error(err); showError('emailError', 'An error occurred'); btn.disabled = false; btn.classList.remove('loading'); btn.innerHTML = orig; }
    });
}

// real-time listeners
const emailEl = document.getElementById('email'); if (emailEl) emailEl.addEventListener('blur', function () { if (this.value && !isValidEmail(this.value)) { this.classList.add('error'); showError('emailError', 'Please enter a valid email address'); } else { this.classList.remove('error'); showError('emailError', ''); } });
const pwEl = document.getElementById('password'); if (pwEl) pwEl.addEventListener('input', function () { if (this.value.length && this.value.length < 6) { this.classList.add('error'); showError('passwordError', 'Password must be at least 6 characters'); } else { this.classList.remove('error'); showError('passwordError', ''); } });

document.addEventListener('DOMContentLoaded', () => console.log('Login.js loaded'));
