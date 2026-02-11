// Enhanced JavaScript for modern web experience
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    initNavigation();
    initScrollAnimations();
    initFormEnhancements();
    initGalleryFeatures();
    initThemeSystem();
    initPerformanceOptimizations();
    initMicroInteractions();
});

// Enhanced navigation system
function initNavigation() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const navbar = document.querySelector('.navbar');
    let lastScrollY = window.scrollY;
    
    // Mobile menu toggle
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
            document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
    
    if (navbar) {
        navbar.style.transform = 'translateY(0)';
    }
    
    // Smooth scroll with offset for fixed headers
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offset = navbar ? navbar.offsetHeight + 20 : 80;
                const targetPosition = target.offsetTop - offset;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (navMenu && navMenu.classList.contains('active')) {
                    navToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }
        });
    });
}

// Advanced scroll animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Add staggered animation for child elements
                const children = entry.target.querySelectorAll('.stagger-item');
                children.forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.add('visible');
                    }, index * 100);
                });
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animatedElements = document.querySelectorAll(
        '.req-card, .timeline-item, .gallery-item, .section-title, .section-subtitle'
    );
    animatedElements.forEach(el => {
        el.classList.add('scroll-animate');
        observer.observe(el);
    });
}

// Enhanced form interactions
function initFormEnhancements() {
    // Form submission handling
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // Reset button after 5 seconds (in case of network issues)
                setTimeout(() => {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });

    // Enhanced password strength
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(input => {
        if (input.name === 'password' || input.name.includes('password')) {
            input.addEventListener('input', function() {
                checkPasswordStrength(this.value, this);
            });
        }
    });

    // Floating labels enhancement
    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach(group => {
        const input = group.querySelector('input:not([type="file"]), textarea');
        const label = group.querySelector('label');
        
        if (input && label && !group.classList.contains('floating')) {
            group.classList.add('floating');
            
            // Add floating behavior
            const updateFloating = () => {
                if (input.value || input === document.activeElement) {
                    label.classList.add('float');
                } else {
                    label.classList.remove('float');
                }
            };
            
            input.addEventListener('focus', updateFloating);
            input.addEventListener('blur', updateFloating);
            input.addEventListener('input', updateFloating);
            updateFloating(); // Initial state
        }
    });

    // Real-time validation
    const requiredFields = document.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                validateField(this);
            }
        });
    });
}

// Gallery enhancements
function initGalleryFeatures() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    galleryItems.forEach((item, index) => {
        const img = item.querySelector('img');
        const overlay = item.querySelector('.gallery-overlay');
        
        // Add loading state
        if (img) {
            img.addEventListener('load', function() {
                item.classList.add('loaded');
            });
            
            img.addEventListener('error', function() {
                item.classList.add('error');
            });
        }
        
        // Enhanced hover effects
        item.addEventListener('mouseenter', function() {
            if (overlay) {
                overlay.style.transform = 'translateY(0)';
            }
            this.classList.add('hovered');
        });
        
        item.addEventListener('mouseleave', function() {
            if (overlay) {
                overlay.style.transform = 'translateY(100%)';
            }
            this.classList.remove('hovered');
        });
        
        // Click to view full image
        item.addEventListener('click', function() {
            if (img) {
                createImageModal(img.src, img.alt);
            }
        });
        
        // Add staggered animation
        item.style.animationDelay = `${index * 0.1}s`;
    });
}

// Theme system (dark/light mode)
function initThemeSystem() {
    const themeToggle = document.querySelector('[data-theme-toggle]');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedTheme = localStorage.getItem('theme');
    const currentTheme = savedTheme || (prefersDark ? 'dark' : 'light');
    
    setTheme(currentTheme);
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const newTheme = document.body.classList.contains('dark-theme') ? 'light' : 'dark';
            setTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem('theme')) {
            setTheme(e.matches ? 'dark' : 'light');
        }
    });
}

function setTheme(theme) {
    document.body.classList.toggle('dark-theme', theme === 'dark');
    document.body.setAttribute('data-theme', theme);
    
    // Update theme toggle if exists
    const themeToggle = document.querySelector('[data-theme-toggle]');
    if (themeToggle) {
        themeToggle.setAttribute('aria-label', `Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`);
    }
}

// Performance optimizations
function initPerformanceOptimizations() {
    // Lazy load images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Debounce scroll events
    let scrollTimeout;
    window.addEventListener('scroll', () => {
        if (scrollTimeout) {
            window.cancelAnimationFrame(scrollTimeout);
        }
        
        scrollTimeout = window.requestAnimationFrame(() => {
            // Handle scroll-based animations
            handleScroll();
        });
    });
    
    // Preload critical resources
    const criticalLinks = document.querySelectorAll('[data-preload]');
    criticalLinks.forEach(link => {
        const preloadLink = document.createElement('link');
        preloadLink.rel = 'preload';
        preloadLink.href = link.getAttribute('data-preload');
        preloadLink.as = link.getAttribute('data-as') || 'script';
        document.head.appendChild(preloadLink);
    });
}

// Micro-interactions
function initMicroInteractions() {
    // Ripple effect on buttons
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
            createRipple(e, this);
        });
    });
    
    // Copy to clipboard with feedback
    const copyButtons = document.querySelectorAll('[data-copy]');
    copyButtons.forEach(btn => {
        btn.addEventListener('click', async function() {
            const text = this.getAttribute('data-copy');
            try {
                await navigator.clipboard.writeText(text);
                showNotification('Copied to clipboard!', 'success');
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 2000);
            } catch (err) {
                showNotification('Failed to copy', 'error');
                console.error('Failed to copy: ', err);
            }
        });
    });
    
    // Tooltip system
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            createTooltip(this);
        });
        
        element.addEventListener('mouseleave', function() {
            removeTooltip();
        });
    });
}

// Utility functions
function handleScroll() {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    
    parallaxElements.forEach(element => {
        const speed = element.dataset.parallax || 0.5;
        const yPos = -(scrolled * speed);
        element.style.transform = `translateY(${yPos}px)`;
    });
}

function createRipple(event, button) {
    const ripple = document.createElement('span');
    const rect = button.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    ripple.classList.add('ripple');
    
    button.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

function createImageModal(src, alt) {
    const modal = document.createElement('div');
    modal.className = 'image-modal';
    modal.innerHTML = `
        <div class="modal-backdrop"></div>
        <div class="modal-content">
            <img src="${src}" alt="${alt}">
            <button class="modal-close" aria-label="Close">&times;</button>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Animate in
    setTimeout(() => modal.classList.add('active'), 10);
    
    // Close handlers
    const closeHandlers = [
        modal.querySelector('.modal-close'),
        modal.querySelector('.modal-backdrop')
    ];
    
    closeHandlers.forEach(handler => {
        handler.addEventListener('click', () => closeModal(modal));
    });
    
    modal.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal(modal);
    });
    
    modal.focus();
}

function closeModal(modal) {
    modal.classList.remove('active');
    setTimeout(() => modal.remove(), 300);
}

function createTooltip(element) {
    removeTooltip();
    
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = element.dataset.tooltip;
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    const tooltipRect = tooltip.getBoundingClientRect();
    
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltipRect.width / 2) + 'px';
    tooltip.style.top = rect.top - tooltipRect.height - 10 + 'px';
    
    setTimeout(() => tooltip.classList.add('visible'), 10);
}

function removeTooltip() {
    const existingTooltip = document.querySelector('.tooltip');
    if (existingTooltip) {
        existingTooltip.remove();
    }
}

function validateField(field) {
    const isValid = field.checkValidity();
    const formGroup = field.closest('.form-group');
    
    if (formGroup) {
        formGroup.classList.toggle('error', !isValid);
        formGroup.classList.toggle('valid', isValid);
        
        // Show/hide error message
        let errorElement = formGroup.querySelector('.field-error');
        if (!isValid && !errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'field-error';
            formGroup.appendChild(errorElement);
        }
        
        if (errorElement) {
            errorElement.textContent = isValid ? '' : field.validationMessage;
        }
    }
    
    return isValid;
}

function checkPasswordStrength(password, input) {
    let strength = 0;
    const checks = {
        length: password.length >= 12,
        longLength: password.length >= 16,
        mixedCase: /[a-z]/.test(password) && /[A-Z]/.test(password),
        numbers: /[0-9]/.test(password),
        special: /[^a-zA-Z0-9]/.test(password)
    };
    
    Object.values(checks).forEach(check => {
        if (check) strength += 20;
    });
    
    // Update or create strength indicator
    let indicator = input.parentNode.querySelector('.password-strength');
    if (!indicator) {
        indicator = document.createElement('div');
        indicator.className = 'password-strength';
        input.parentNode.appendChild(indicator);
    }
    
    indicator.style.width = strength + '%';
    indicator.className = `password-strength strength-${
        strength < 40 ? 'weak' : strength < 70 ? 'medium' : 'strong'
    }`;
    
    // Update requirements list if exists
    const requirementsList = input.parentNode.querySelector('.password-requirements');
    if (requirementsList) {
        Object.entries(checks).forEach(([key, passed]) => {
            const requirement = requirementsList.querySelector(`[data-requirement="${key}"]`);
            if (requirement) {
                requirement.classList.toggle('passed', passed);
            }
        });
    }
}

// Enhanced notification system
function showNotification(message, type = 'info', duration = 4000) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close" aria-label="Close">&times;</button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => notification.classList.add('visible'), 10);
    
    // Auto remove
    const removeTimeout = setTimeout(() => removeNotification(notification), duration);
    
    // Manual close
    notification.querySelector('.notification-close').addEventListener('click', () => {
        clearTimeout(removeTimeout);
        removeNotification(notification);
    });
}

function removeNotification(notification) {
    notification.classList.add('removing');
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 300);
}

// Dynamic sidebar toggle
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
    }
}

// Initialize sidebar state
function initSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
    
    if (sidebar && isCollapsed) {
        sidebar.classList.add('collapsed');
    }
    
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
}

// Export functions for global access
window.showNotification = showNotification;
window.toggleSidebar = toggleSidebar;
window.createImageModal = createImageModal;

// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 12) strength += 25;
    if (password.length >= 16) strength += 25;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
    if (/[0-9]/.test(password)) strength += 12.5;
    if (/[^a-zA-Z0-9]/.test(password)) strength += 12.5;
    
    // Update strength indicator if exists
    const indicator = document.querySelector('.password-strength');
    if (indicator) {
        indicator.style.width = strength + '%';
        indicator.className = 'password-strength strength-' + (strength < 50 ? 'weak' : strength < 75 ? 'medium' : 'strong');
    }
}

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    Object.assign(notification.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        padding: '15px 20px',
        borderRadius: '8px',
        color: 'white',
        fontSize: '14px',
        fontWeight: '600',
        zIndex: '9999',
        transform: 'translateX(400px)',
        transition: 'transform 0.3s ease'
    });
    
    switch(type) {
        case 'success':
            notification.style.backgroundColor = '#10b981';
            break;
        case 'error':
            notification.style.backgroundColor = '#ef4444';
            break;
        case 'warning':
            notification.style.backgroundColor = '#f59e0b';
            break;
        default:
            notification.style.backgroundColor = '#3b82f6';
    }
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 1;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .password-strength {
        height: 4px;
        border-radius: 2px;
        margin-top: 8px;
        transition: all 0.3s ease;
        background: #e5e7eb;
        width: 0%;
    }
    
    .password-strength.strength-weak {
        background: #ef4444;
    }
    
    .password-strength.strength-medium {
        background: #f59e0b;
    }
    
    .password-strength.strength-strong {
        background: #10b981;
    }
`;
document.head.appendChild(style);