class DashboardManager {
    constructor() {
        this.init();
        this.startInactivityMonitor();
    }

    init() {
        // Initialize tooltips
        this.initTooltips();
        
        // Initialize charts
        this.initCharts();
        
        // Auto-refresh stats every 30 seconds
        this.startAutoRefresh();
        
        // Initialize real-time updates
        this.startRealTimeUpdates();
    }

    initTooltips() {
        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    initCharts() {
        // Initialize activity chart if canvas exists
        const activityChart = document.getElementById('activityChart');
        if (activityChart) {
            this.initActivityChart();
        }
    }

    initActivityChart() {
        // This would integrate with Chart.js or similar
        console.log('Initializing activity chart...');
        // Chart implementation would go here
    }

    startAutoRefresh() {
        setInterval(() => {
            this.refreshStats();
        }, 30000); // 30 seconds
    }

    startRealTimeUpdates() {
        // Simulate real-time updates
        setInterval(() => {
            this.simulateRealTimeActivity();
        }, 10000); // 10 seconds
    }

    async refreshStats() {
        try {
            const response = await fetch('/api/user-stats');
            const stats = await response.json();
            
            // Update stats cards dynamically
            this.updateStatsCards(stats);
            
            // Show refresh indicator
            this.showRefreshIndicator();
            
        } catch (error) {
            console.error('Failed to refresh stats:', error);
        }
    }

    updateStatsCards(stats) {
        // Update stats cards with new data
        // This would dynamically update the numbers on the dashboard
        console.log('Updating stats with:', stats);
    }

    showRefreshIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'notification-toast alert alert-success alert-dismissible fade show';
        indicator.innerHTML = `
            <strong>Updated!</strong> Dashboard stats refreshed.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(indicator);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (indicator.parentElement) {
                indicator.remove();
            }
        }, 3000);
    }

    simulateRealTimeActivity() {
        // Simulate new activity notifications
        if (Math.random() > 0.7) { // 30% chance
            this.showActivityNotification();
        }
    }

    showActivityNotification() {
        const activities = [
            'New user registered',
            'File uploaded by user',
            'System backup completed',
            'Security scan finished',
            'Performance optimized'
        ];
        
        const randomActivity = activities[Math.floor(Math.random() * activities.length)];
        
        const notification = document.createElement('div');
        notification.className = 'notification-toast alert alert-info alert-dismissible fade show';
        notification.innerHTML = `
            <strong>Activity:</strong> ${randomActivity}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    startInactivityMonitor() {
        // Initialize inactivity monitoring
        if (typeof InactivityMonitor !== 'undefined') {
            window.inactivityMonitor = new InactivityMonitor();
        }
    }

    // Export dashboard data
    exportDashboardData() {
        const data = {
            timestamp: new Date().toISOString(),
            user: window.userData || {},
            stats: this.getCurrentStats()
        };
        
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `dashboard-export-${new Date().getTime()}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    getCurrentStats() {
        // Get current stats from DOM
        return {
            totalUsers: document.querySelector('[data-stat="total-users"]')?.textContent,
            activeUsers: document.querySelector('[data-stat="active-users"]')?.textContent,
            totalActivities: document.querySelector('[data-stat="total-activities"]')?.textContent,
            activePenalties: document.querySelector('[data-stat="active-penalties"]')?.textContent
        };
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.dashboardManager = new DashboardManager();
    
    // Add global refresh function
    window.refreshStats = function() {
        window.dashboardManager.refreshStats();
    };
    
    // Add export function
    window.exportDashboard = function() {
        window.dashboardManager.exportDashboardData();
    };
});