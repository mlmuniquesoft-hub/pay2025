// Modern Tree View JavaScript - Bootstrap 5 Based

class ModernTreeView {
    constructor() {
        this.zoomLevel = 1;
        this.isFullscreen = false;
        this.init();
    }

    init() {
        console.log('Initializing Modern Tree View...');
        this.setupEventListeners();
        this.initTooltips();
        this.initSidebar();
        // Don't call loadTree here to avoid overwriting PHP content
        // Just animate existing nodes after a small delay
        setTimeout(() => {
            this.animateTreeNodes();
        }, 100);
    }

    setupEventListeners() {
        // Sidebar toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => this.toggleSidebar());
        }

        // Search functionality
        const searchInput = document.getElementById('searchUser');
        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.searchInTree();
                }
            });
        }

        // Window resize handling
        window.addEventListener('resize', () => this.handleResize());

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => this.handleKeyboardShortcuts(e));
    }

    initTooltips() {
        // Initialize Bootstrap 5 tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    initSidebar() {
        // Handle sidebar state
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('main');
        
        // Load saved sidebar state
        const sidebarState = localStorage.getItem('modernTreeSidebarCollapsed');
        if (sidebarState === 'true') {
            this.collapseSidebar();
        }
    }

    toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('main');
        const isCollapsed = sidebar.classList.contains('collapsed');
        
        if (isCollapsed) {
            this.expandSidebar();
        } else {
            this.collapseSidebar();
        }
        
        // Save state
        localStorage.setItem('modernTreeSidebarCollapsed', !isCollapsed);
    }

    collapseSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('main');
        
        sidebar.classList.add('collapsed');
        main.classList.add('content-shifted');
        
        // Update toggle icon
        const toggleIcon = document.querySelector('#sidebarToggle i');
        if (toggleIcon) {
            toggleIcon.className = 'fas fa-chevron-right';
        }
    }

    expandSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('main');
        
        sidebar.classList.remove('collapsed');
        main.classList.remove('content-shifted');
        
        // Update toggle icon
        const toggleIcon = document.querySelector('#sidebarToggle i');
        if (toggleIcon) {
            toggleIcon.className = 'fas fa-bars';
        }
    }

    loadTree() {
        // Tree is already rendered by PHP, just animate it
        this.animateTreeNodes();
    }

    showLoading() {
        // Only show loading if tree container is empty
        const treeContainer = document.getElementById('tree');
        if (treeContainer && !treeContainer.querySelector('.tree-node-container')) {
            treeContainer.innerHTML = `
                <div class="tree-loading">
                    <div class="loading-spinner"></div>
                    <div class="ms-3">Loading tree structure...</div>
                </div>
            `;
        }
    }

    hideLoading() {
        // Remove loading elements if they exist
        const loadingElements = document.querySelectorAll('.tree-loading');
        loadingElements.forEach(element => element.remove());
    }

    animateTreeNodes() {
        console.log('Animating tree nodes...');
        const nodes = document.querySelectorAll('.bs5-tree-node .node, .empty-node');
        console.log('Found nodes:', nodes.length);
        
        if (nodes.length === 0) {
            console.log('No nodes found to animate');
            return;
        }
        
        nodes.forEach((node, index) => {
            // Ensure nodes are visible
            node.style.opacity = '1';
            node.style.transform = 'translateY(0)';
            
            // Add subtle entrance animation with staggered delay
            node.style.animation = `nodeEnter 0.6s ease forwards`;
            node.style.animationDelay = `${index * 0.15}s`;
        });
    }

    zoomIn() {
        if (this.zoomLevel < 2) {
            this.zoomLevel += 0.2;
            this.applyZoom();
        }
    }

    zoomOut() {
        if (this.zoomLevel > 0.5) {
            this.zoomLevel -= 0.2;
            this.applyZoom();
        }
    }

    resetZoom() {
        this.zoomLevel = 1;
        this.applyZoom();
    }

    applyZoom() {
        const zoomContainer = document.querySelector('.tree-zoom-container');
        if (zoomContainer) {
            zoomContainer.style.transform = `scale(${this.zoomLevel})`;
        }
    }

    toggleFullscreen() {
        const treeContainer = document.getElementById('treeContainer');
        
        if (!this.isFullscreen) {
            treeContainer.classList.add('tree-fullscreen');
            this.isFullscreen = true;
            
            // Update button icon
            const fullscreenBtn = document.querySelector('[onclick="toggleFullscreen()"] i');
            if (fullscreenBtn) {
                fullscreenBtn.className = 'fas fa-compress me-2';
            }
        } else {
            treeContainer.classList.remove('tree-fullscreen');
            this.isFullscreen = false;
            
            // Update button icon
            const fullscreenBtn = document.querySelector('[onclick="toggleFullscreen()"] i');
            if (fullscreenBtn) {
                fullscreenBtn.className = 'fas fa-expand me-2';
            }
        }
    }

    searchInTree() {
        const searchTerm = document.getElementById('searchUser').value.toLowerCase().trim();
        
        if (!searchTerm) {
            this.clearSearchHighlights();
            return;
        }

        this.clearSearchHighlights();
        
        const nodes = document.querySelectorAll('.modern-tree-node');
        let found = false;
        
        nodes.forEach(node => {
            const userName = node.querySelector('.user-name').textContent.toLowerCase();
            const userId = node.querySelector('.user-id').textContent.toLowerCase();
            
            if (userName.includes(searchTerm) || userId.includes(searchTerm)) {
                node.classList.add('search-highlight');
                node.scrollIntoView({ behavior: 'smooth', block: 'center' });
                found = true;
            }
        });
        
        if (!found) {
            this.showNotification('User not found in current tree view', 'warning');
        } else {
            this.showNotification('User found and highlighted', 'success');
        }
    }

    clearSearchHighlights() {
        const highlightedNodes = document.querySelectorAll('.search-highlight');
        highlightedNodes.forEach(node => {
            node.classList.remove('search-highlight');
        });
    }

    viewUserTree(userId) {
        // Navigate to user's tree
        const encodedUserId = btoa(userId);
        window.location.href = `index.php?ref=${encodedUserId}`;
    }

    showNotification(message, type = 'info') {
        // Create notification toast
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        
        // Add to toast container or create one
        let toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }
        
        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        
        // Initialize and show toast
        const toastElement = toastContainer.lastElementChild;
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
        
        // Remove toast element after it's hidden
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }

    handleResize() {
        // Handle responsive behavior
        const sidebar = document.getElementById('sidebar');
        const screenWidth = window.innerWidth;
        
        if (screenWidth < 768) {
            // Mobile: always collapse sidebar
            if (!sidebar.classList.contains('collapsed')) {
                this.collapseSidebar();
            }
        }
    }

    handleKeyboardShortcuts(e) {
        // Handle keyboard shortcuts
        if (e.ctrlKey || e.metaKey) {
            switch (e.key) {
                case '=':
                case '+':
                    e.preventDefault();
                    this.zoomIn();
                    break;
                case '-':
                    e.preventDefault();
                    this.zoomOut();
                    break;
                case '0':
                    e.preventDefault();
                    this.resetZoom();
                    break;
                case 'f':
                    e.preventDefault();
                    this.toggleFullscreen();
                    break;
            }
        }
        
        // ESC key to exit fullscreen
        if (e.key === 'Escape' && this.isFullscreen) {
            this.toggleFullscreen();
        }
    }
}

// Global functions for backward compatibility
function zoomIn() {
    if (window.modernTree) {
        window.modernTree.zoomIn();
    }
}

function zoomOut() {
    if (window.modernTree) {
        window.modernTree.zoomOut();
    }
}

function resetZoom() {
    if (window.modernTree) {
        window.modernTree.resetZoom();
    }
}

function toggleFullscreen() {
    if (window.modernTree) {
        window.modernTree.toggleFullscreen();
    }
}

function searchInTree() {
    if (window.modernTree) {
        window.modernTree.searchInTree();
    }
}

// Global functions for compatibility with original tree
function getGenologyTree(userId, event) {
    if (event) {
        event.preventDefault();
    }
    
    // Don't navigate for empty nodes
    if (userId === 'Add Here' || !userId || userId.trim() === '') {
        console.log('Empty node clicked, not navigating');
        return false;
    }
    
    console.log('Navigating to tree for user:', userId);
    viewUserTree(userId);
    return false;
}

function viewUserTree(userId) {
    if (window.modernTree) {
        window.modernTree.viewUserTree(userId);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.modernTree = new ModernTreeView();
    
    // Add some extra functionality
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Auto-hide mobile sidebar when clicking outside
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const screenWidth = window.innerWidth;
        
        if (screenWidth < 768 && 
            !sidebar.contains(e.target) && 
            !sidebarToggle.contains(e.target) &&
            !sidebar.classList.contains('collapsed')) {
            window.modernTree.collapseSidebar();
        }
    });
    
    // Add loading states to buttons
    document.querySelectorAll('button, .btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!this.classList.contains('loading')) {
                this.classList.add('loading');
                setTimeout(() => {
                    this.classList.remove('loading');
                }, 1000);
            }
        });
    });
});

// Handle page visibility changes
document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'visible') {
        // Refresh data when page becomes visible again
        console.log('Page is now visible, refreshing tree data...');
        // Add your refresh logic here
    }
});

// Export for module usage if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ModernTreeView;
}