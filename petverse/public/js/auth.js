// public copy loads resources version if available
// try to load compiled resource; fallback to embedded
// Bundled auth logic (copied from resources/js/auth.js) - ensures runtime availability
// Shared auth JS for login/register/admin views
function togglePasswordFor(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.type = el.type === 'password' ? 'text' : 'password';
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function showError(id, msg){
    const el = document.getElementById(id);
    if(el) el.textContent = msg;
}

function showNotification(message){
    const n = document.createElement('div');
    n.textContent = message;
    n.style.cssText = 'position:fixed;top:20px;right:20px;background:#FF6B35;color:#fff;padding:12px 16px;border-radius:8px;z-index:9999;';
    document.body.appendChild(n);
    setTimeout(()=> n.remove(), 3000);
}

// pet chips for register page
document.addEventListener('click', function(e){
    if(e.target && e.target.classList && e.target.classList.contains('pet-chip')){
        document.querySelectorAll('.pet-chip').forEach(c=>c.classList.remove('active'));
        e.target.classList.add('active');
        const v = e.target.getAttribute('data-value');
        const input = document.getElementById('pet_type');
        if(input) input.value = v;
    }
});

// REGISTER form
const registerForm = document.getElementById('registerForm');
if(registerForm){
    registerForm.addEventListener('submit', async function(e){
        e.preventDefault();
        // basic validation
        const first = document.getElementById('first_name').value.trim();
        const last = document.getElementById('last_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const pw = document.getElementById('password').value;
        const pw2 = document.getElementById('password_confirmation').value;
        let ok = true;
        showError('firstNameError',''); showError('lastNameError',''); showError('emailError',''); showError('passwordError',''); showError('confirmPasswordError','');

        if(!first){ showError('firstNameError','First name is required'); ok=false; }
        if(!last){ showError('lastNameError','Last name is required'); ok=false; }
        if(!email || !isValidEmail(email)){ showError('emailError','Valid email required'); ok=false; }
        if(pw.length < 8){ showError('passwordError','Password must be at least 8 chars'); ok=false; }
        if(pw !== pw2){ showError('confirmPasswordError','Passwords do not match'); ok=false; }
        if(!ok) return;

        const btn = registerForm.querySelector('.login-btn');
        const orig = btn.innerHTML;
        btn.disabled = true; btn.textContent = 'Creating...';

        try{
            const token = document.querySelector('input[name="_token"]').value;
            const data = new URLSearchParams(new FormData(registerForm));
            const res = await fetch(window.routes.registerSubmit || '/register', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: data
            });
            if(res.ok){
                showNotification('Account created — redirecting...');
                const json = await res.json();
                setTimeout(()=> window.location.href = json.redirect || window.routes.login || '/', 900);
            } else {
                const json = await res.json();
                showError('emailError', json.message || 'Registration failed');
                btn.disabled = false; btn.innerHTML = orig;
            }
        }catch(err){
            console.error(err);
            showError('emailError','An error occurred');
            btn.disabled = false; btn.innerHTML = orig;
        }
    });
}

// ADMIN login
const adminForm = document.getElementById('adminLoginForm');
if(adminForm){
    adminForm.addEventListener('submit', async function(e){
        e.preventDefault();
        showError('adminEmailError',''); showError('adminPasswordError','');
        const email = document.getElementById('admin_email').value.trim();
        const pw = document.getElementById('admin_password').value;
        if(!email){ showError('adminEmailError','Email is required'); return; }
        if(!pw){ showError('adminPasswordError','Password is required'); return; }

        const btn = adminForm.querySelector('.login-btn');
        const orig = btn.innerHTML;
        btn.disabled = true; btn.textContent = 'Accessing...';

        try{
            const token = document.querySelector('input[name="_token"]').value;
            const data = new URLSearchParams(new FormData(adminForm));
            const res = await fetch(window.routes.adminLogin || '/admin/login', {
                method: 'POST', headers: { 'X-CSRF-TOKEN': token }, body: data
            });
            const j = await res.json();
            if(res.ok){
                showNotification('Welcome back, admin');
                setTimeout(()=> window.location.href = j.redirect || '/admin/dashboard', 700);
            } else {
                showError('adminEmailError', j.message || 'Login failed');
                btn.disabled=false; btn.innerHTML = orig;
            }
        }catch(err){ console.error(err); showError('adminEmailError','An error occurred: ' + err.message); btn.disabled=false; btn.innerHTML=orig; }
    });
}

// LOGIN page uses existing public/js/login.js — it will read window.routes.loginSubmit
document.addEventListener('DOMContentLoaded', ()=> console.log('Auth scripts initialized'));
