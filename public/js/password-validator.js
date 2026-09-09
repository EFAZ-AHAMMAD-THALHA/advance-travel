/**
 * Advance Travel & Tourism - Client-side Password Strength & Validation Script
 * Enhances user experience with real-time requirements checklist, strength meter, and password visibility toggles.
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Password Visibility Toggle Functionality
    const toggleBtns = document.querySelectorAll('.toggle-password-btn');
    toggleBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId) || this.previousElementSibling || this.closest('.input-group').querySelector('input');
            if (!targetInput) return;

            const icon = this.querySelector('i');
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                if (icon) {
                    icon.classList.remove('bx-hide', 'bx-show');
                    icon.classList.add('bx-show');
                }
            } else {
                targetInput.type = 'password';
                if (icon) {
                    icon.classList.remove('bx-show', 'bx-hide');
                    icon.classList.add('bx-hide');
                }
            }
        });
    });

    // 2. Real-time Password Strength & Criteria Validation
    const passwordInputs = document.querySelectorAll('[data-password-strength]');
    passwordInputs.forEach(function (passwordInput) {
        const container = passwordInput.closest('form') || passwordInput.closest('.card') || document;
        const confirmInputId = passwordInput.getAttribute('data-confirm-input');
        const confirmInput = confirmInputId ? document.getElementById(confirmInputId) : container.querySelector('[name="password_confirmation"]');

        const strengthMeterBar = container.querySelector('.password-strength-bar');
        const strengthMeterText = container.querySelector('.password-strength-text');
        
        // Checklist elements
        const reqLength = container.querySelector('[data-req="length"]');
        const reqUppercase = container.querySelector('[data-req="uppercase"]');
        const reqLowercase = container.querySelector('[data-req="lowercase"]');
        const reqNumber = container.querySelector('[data-req="number"]');
        const reqSpecial = container.querySelector('[data-req="special"]');
        const reqMatch = container.querySelector('[data-req="match"]');

        function updateChecklistItem(element, isPassed) {
            if (!element) return;
            const icon = element.querySelector('i');
            if (isPassed) {
                element.classList.remove('text-muted', 'text-danger');
                element.classList.add('text-success', 'fw-medium');
                if (icon) {
                    icon.className = 'bx bx-check-circle me-1 text-success';
                }
            } else {
                element.classList.remove('text-success', 'fw-medium');
                element.classList.add('text-muted');
                if (icon) {
                    icon.className = 'bx bx-circle me-1 opacity-50';
                }
            }
        }

        function evaluatePassword() {
            const val = passwordInput.value || '';
            const confirmVal = confirmInput ? confirmInput.value || '' : '';

            const hasMinLength = val.length >= 8;
            const hasUpper = /[A-Z]/.test(val);
            const hasLower = /[a-z]/.test(val);
            const hasNumber = /[0-9]/.test(val);
            const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(val);
            const isMatching = confirmVal.length > 0 && val === confirmVal;

            updateChecklistItem(reqLength, hasMinLength);
            updateChecklistItem(reqUppercase, hasUpper);
            updateChecklistItem(reqLowercase, hasLower);
            updateChecklistItem(reqNumber, hasNumber);
            updateChecklistItem(reqSpecial, hasSpecial);

            if (reqMatch) {
                if (confirmVal.length === 0) {
                    updateChecklistItem(reqMatch, false);
                } else if (isMatching) {
                    updateChecklistItem(reqMatch, true);
                } else {
                    reqMatch.classList.remove('text-muted', 'text-success');
                    reqMatch.classList.add('text-danger');
                    const icon = reqMatch.querySelector('i');
                    if (icon) icon.className = 'bx bx-x-circle me-1 text-danger';
                }
            }

            // Calculate strength score (0 to 5)
            let score = 0;
            if (hasMinLength) score++;
            if (hasUpper) score++;
            if (hasLower) score++;
            if (hasNumber) score++;
            if (hasSpecial) score++;

            // Extra bonus for length >= 12
            let label = '';
            let widthPct = 0;
            let barColorClass = 'bg-danger';

            if (val.length === 0) {
                label = 'Password Required';
                widthPct = 0;
                barColorClass = 'bg-secondary';
            } else if (score <= 1) {
                label = 'Very Weak';
                widthPct = 20;
                barColorClass = 'bg-danger';
            } else if (score === 2) {
                label = 'Weak';
                widthPct = 40;
                barColorClass = 'bg-warning';
            } else if (score === 3) {
                label = 'Medium';
                widthPct = 60;
                barColorClass = 'bg-info';
            } else if (score === 4) {
                label = 'Strong';
                widthPct = 80;
                barColorClass = 'bg-primary';
            } else if (score === 5) {
                label = 'Very Strong & Secure';
                widthPct = 100;
                barColorClass = 'bg-success';
            }

            if (strengthMeterBar) {
                strengthMeterBar.style.width = widthPct + '%';
                strengthMeterBar.className = 'progress-bar password-strength-bar transition-all ' + barColorClass;
            }

            if (strengthMeterText) {
                strengthMeterText.textContent = label;
                strengthMeterText.className = 'password-strength-text small ms-auto fw-bold ' + 
                    (barColorClass.replace('bg-', 'text-'));
            }
        }

        passwordInput.addEventListener('input', evaluatePassword);
        passwordInput.addEventListener('keyup', evaluatePassword);

        if (confirmInput) {
            confirmInput.addEventListener('input', evaluatePassword);
            confirmInput.addEventListener('keyup', evaluatePassword);
        }

        // Run initial calculation if value exists
        if (passwordInput.value) {
            evaluatePassword();
        }
    });
});
