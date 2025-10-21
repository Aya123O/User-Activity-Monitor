// public/js/inactivity-monitor.js
class InactivityMonitor {
    constructor() {
        this.timeout = null;
        this.alertShown = false;
        this.warningShown = false;
        this.logoutShown = false;
        this.alertTimeout = 5000; // 5 seconds
        this.warningTimeout = 10000; // 10 seconds
        this.logoutTimeout = 15000; // 15 seconds
        this.lastActivity = Date.now();
        
        this.init();
    }

    init() {
        // Track user activity
        this.bindEvents();
        
        // Start monitoring
        this.startMonitoring();
        
        // Ping server every minute to update last activity
        setInterval(() => this.pingServer(), 60000);
    }

    bindEvents() {
        const events = ['mousemove', 'keypress', 'scroll', 'click', 'touchstart'];
        
        events.forEach(event => {
            document.addEventListener(event, () => {
                this.resetTimer();
                this.updateLastActivity();
            });
        });

        // Prevent browser tab sleep
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                this.resetTimer();
            }
        });
    }

    startMonitoring() {
        this.timeout = setTimeout(() => {
            this.checkInactivity();
        }, 1000);
    }

    resetTimer() {
        clearTimeout(this.timeout);
        this.startMonitoring();
    }

    updateLastActivity() {
        this.lastActivity = Date.now();
    }

    checkInactivity() {
        const idleTime = Date.now() - this.lastActivity;
        
        if (idleTime >= this.logoutTimeout && !this.logoutShown) {
            this.handleLogout();
        } else if (idleTime >= this.warningTimeout && !this.warningShown) {
            this.handleWarning();
        } else if (idleTime >= this.alertTimeout && !this.alertShown) {
            this.handleAlert();
        }
    }

    handleAlert() {
        this.alertShown = true;
        this.showNotification('Inactivity Alert', 'You have been inactive for a while.', 'warning');
        
        // Log to server
        this.logInactivity('alert', this.alertTimeout / 1000);
    }

    handleWarning() {
        this.warningShown = true;
        this.showNotification('Inactivity Warning', 'You will be logged out soon due to inactivity.', 'error');
        
        // Log to server
        this.logInactivity('warning', this.warningTimeout / 1000);
    }

    handleLogout() {
        this.logoutShown = true;
        this.showNotification('Session Expired', 'You have been logged out due to inactivity.', 'error');
        
        // Log to server
        this.logInactivity('logout', this.logoutTimeout / 1000);
        
        // Redirect to logout after 3 seconds
        setTimeout(() => {
            window.location.href = '/logout';
        }, 3000);
    }

    showNotification(title, message, type) {
        // Create custom notification
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg border-l-4 ${
            type === 'warning' ? 'bg-yellow-50 border-yellow-400 text-yellow-800' :
            type === 'error' ? 'bg-red-50 border-red-400 text-red-800' :
            'bg-blue-50 border-blue-400 text-blue-800'
        } z-50 max-w-sm`;
        
        notification.innerHTML = `
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-${
                        type === 'warning' ? 'exclamation-triangle' :
                        type === 'error' ? 'exclamation-circle' : 'info-circle'
                    }"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">${title}</h3>
                    <div class="mt-1 text-sm">${message}</div>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.remove()" class="inline-flex text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    async logInactivity(type, duration) {
        try {
            await fetch('/api/inactivity-log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    type: type,
                    duration: duration
                })
            });
        } catch (error) {
            console.error('Failed to log inactivity:', error);
        }
    }

    async pingServer() {
        try {
            await fetch('/api/activity-ping', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        } catch (error) {
            console.error('Activity ping failed:', error);
        }
    }

    updateTimeouts(alert, warning, logout) {
        this.alertTimeout = alert * 1000;
        this.warningTimeout = warning * 1000;
        this.logoutTimeout = logout * 1000;
    }
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    window.inactivityMonitor = new InactivityMonitor();
});