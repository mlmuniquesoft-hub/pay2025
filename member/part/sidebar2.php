<div class="page-sidebar-tree" id="tree-sidebar">
    <!-- MAIN MENU - START -->
    <div class="page-sidebar-wrapper-tree" id="main-menu-wrapper-tree">
        <div class="sidebar-header-tree">
            <button class="sidebar-close-btn" id="closeSidebarTree">&times;</button>
        </div>
        
        <ul class='wraplist-tree' style="margin-top:60px;background:rgba(0, 0, 0, 0.38)">
            <li class='menusection-tree'>Main</li>
            <li class="">
                <a href="../index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            
            <li class="">
                <a href="javascript:;" class="has-submenu">
                     <i class="fa fa-user"></i>
                    <span class="title">Profile</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu-tree">
                    <li>
                        <a href="../index.php?route=profile&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('User Profile'); ?>">Trader Profile</a>
                    </li>
                    <li>
                        <a href="../index.php?route=edit_profile&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Profile Edit'); ?>">Personal Settings</a>
                    </li>
                    <li>
                        <a href="../index.php?route=security&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Account Security'); ?>">Account Settings</a>
                    </li>
                </ul>
            </li>
            
            <li class="">
                <a href="../index.php?route=trade_plan&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Trader Plans'); ?>">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="title">Upgrade Package</span>
                </a>
            </li>
            
            <li class="">
                <a href="javascript:;" class="has-submenu">
                    <i class="fa fa-line-chart"></i>
                    <span class="title">Binary Tree</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu-tree">
                    <li>
						<a class="" href="index.php?route=sponsor_list&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Sponsor Team'); ?>">Sponsor List</a>
					</li>
					<li>
						<a class="" href="index.php?route=unilevel_view&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Unilevel View'); ?>">Unilevel</a>
					</li>
					<li>
						<a class="" href="index.php?route=tree_view&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Tree View'); ?>">My Tree</a>
					</li>
                </ul>
            </li>
            
            <li class="">
                <a href="javascript:;" class="has-submenu">
                    <i class="fa fa-money"></i>
                    <span class="title">Financial</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu-tree">
					<li>
						<a class="" href="index.php?route=wallet_user&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Add Wallet/User'); ?>">Add Wallet</a>
					</li>
					<li class="">
						<ul class="sub-menu">
							<li>
								<a class="" href="index.php?route=deposit&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Deposit Fund'); ?>">
									<i class="fa fa-bitcoin" style="margin-right: 5px; color: #f7931a;"></i>
									Add Funds
								</a>
							</li>
							<li>
								<a class="" href="index.php?route=deposit_history&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Deposit Status'); ?>">
									<i class="fa fa-clock-o" style="margin-right: 5px; color: #ffc107;"></i>
									Pending Status
								</a>
							</li>
						</ul>
					</li>
					<li>
						<a class="" href="index.php?route=withdraw&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Withdraw Fund '); ?>">
							<i class="fa fa-minus-circle" style="margin-right: 5px; color: #dc3545;"></i>
							Withdraw
						</a>
					</li>
					<li>
						<a class="" href="index.php?route=transfer&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Transfer Fund '); ?>">
							<i class="fa fa-exchange" style="margin-right: 5px; color: #6f42c1;"></i>
							Transfer
						</a>
					</li>
                </ul>
            </li>
            
            <li class="">
                <a href="javascript:;" class="has-submenu">
                    <i class="fa fa-bar-chart"></i>
                    <span class="title">Reports</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu-tree">
                    <li>
						<a class="" href="index.php?route=deposit_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('All Deposit History'); ?>">
							<i class="fa fa-plus-square" style="margin-right: 5px; color: #28a745;"></i>
							All Deposits
						</a>
					</li>
					<li>
						<a class="" href="index.php?route=deposit&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Manual Deposits'); ?>">
							<i class="fa fa-file-image-o" style="margin-right: 5px; color: #17a2b8;"></i>
							Manual Deposits
						</a>
					</li>
					<li>
						<a class="" href="index.php?route=withdraw_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Withdraw History'); ?>">
							<i class="fa fa-minus-square" style="margin-right: 5px; color: #dc3545;"></i>
							Withdrawals
						</a>
					</li>
					
					<li>
						<a class="" href="index.php?route=transfer_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Transfer History'); ?>">
							<i class="fa fa-arrow-right" style="margin-right: 5px; color: #6f42c1;"></i>
							Transfers
						</a>
					</li>
					<li>
						<a class="" href="index.php?route=activation_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Activation Report'); ?>">
							<i class="fa fa-rocket" style="margin-right: 5px; color: #f59e0b;"></i>
							Activations
						</a>
					</li>
					<li>
						<a class="" href="index.php?route=receive_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Receive History'); ?>">
							<i class="fa fa-arrow-left" style="margin-right: 5px; color: #20c997;"></i>
							Received
						</a>
					</li>
                </ul>
            </li>
            
            <li class="">
				<a href="index.php?route=common_question&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('FAQ'); ?>">
					<i class="fa fa-linode">
						
					</i>
					<span class="title">Ranks</span>
				</a>
			</li>
            
            <li class="">
                <a href="../logout.php">
                    <i class="fa fa-sign-out"></i>
                    <span class="title">Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- MAIN MENU - END -->
</div>

<!-- Tree Sidebar Styles -->
<style>
.page-sidebar-tree {
    position: fixed;
    top: 0;
    left: -280px; /* Start hidden */
    width: 280px;
    height: 100vh;
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    z-index: 9999;
    transition: left 0.3s ease;
    box-shadow: 2px 0 10px rgba(0,0,0,0.3);
    overflow-y: auto;
}

.page-sidebar-tree.show {
    left: 0; /* Show when toggled */
}

.page-sidebar-wrapper-tree {
    padding: 0;
    height: 100%;
}

.sidebar-header-tree {
    padding: 15px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    display: flex;
    justify-content: flex-end;
    position: relative;
    height: 60px;
}

.sidebar-close-btn {
    background: rgba(220, 53, 69, 0.8);
    border: none;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.3s ease;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 10001;
}

.sidebar-close-btn:hover {
    background: rgba(220, 53, 69, 1);
    transform: scale(1.1);
}

.wraplist-tree {
    list-style: none;
    margin: 0;
    padding: 0;
    background: rgba(0,0,0,0.3);
}

.wraplist-tree li {
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.wraplist-tree li a {
    color: #ecf0f1;
    text-decoration: none;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    position: relative;
}

.wraplist-tree li a:hover {
    background: rgba(255,255,255,0.1);
    color: #fff;
    text-decoration: none;
}

.wraplist-tree li a i {
    margin-right: 12px;
    font-size: 16px;
    width: 20px;
    text-align: center;
}

.wraplist-tree li a .title {
    flex: 1;
}

.wraplist-tree li a .arrow {
    margin-left: auto;
    transition: transform 0.3s ease;
}

.wraplist-tree li a .arrow:after {
    content: '▼';
    font-size: 10px;
}

.wraplist-tree li a.active .arrow {
    transform: rotate(180deg);
}

.sub-menu-tree {
    list-style: none;
    margin: 0;
    padding: 0;
    background: rgba(0,0,0,0.2);
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.sub-menu-tree.show {
    max-height: 300px; /* Adjust as needed */
}

.sub-menu-tree li a {
    padding: 10px 20px 10px 50px;
    font-size: 13px;
    border-bottom: 1px solid rgba(255,255,255,0.02);
}

.menusection-tree {
    color: #95a5a6 !important;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
    padding: 15px 20px 8px 20px;
    letter-spacing: 1px;
}

/* Overlay when sidebar is open */
.sidebar-overlay-tree {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.sidebar-overlay-tree.show {
    opacity: 1;
    visibility: visible;
}

/* Desktop behavior - sidebar closed by default */
@media (min-width: 769px) {
    .page-sidebar-tree {
        left: -280px !important; /* Default closed on desktop too */
    }
    
    .page-sidebar-tree.show {
        left: 0 !important; /* Show when toggled */
    }
}

/* Mobile responsive behavior */
@media (max-width: 768px) {
    .page-sidebar-tree {
        width: 280px;
        left: -280px !important; /* Force closed on mobile */
    }
    
    .page-sidebar-tree.show {
        left: 0 !important; /* Show when toggled */
    }
    
    /* Ensure close button is always visible on mobile */
    .sidebar-close-btn {
        display: block !important;
        position: absolute;
        top: 10px;
        right: 15px;
        z-index: 10000;
        background: rgba(0,0,0,0.5) !important;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .page-sidebar-tree {
        width: 260px;
        left: -260px !important;
    }
}
</style>

<!-- Tree Sidebar JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Tree Sidebar 2.0 Initializing...');
    
    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay-tree';
    document.body.appendChild(overlay);
    
    const sidebar = document.getElementById('tree-sidebar');
    const closeBtn = document.getElementById('closeSidebarTree');
    
    // Toggle function
    function toggleSidebar() {
        console.log('🎯 Toggle sidebar function called');
        if (!sidebar) {
            console.error('❌ Sidebar element not found!');
            return;
        }
        
        const isOpen = sidebar.classList.contains('show');
        console.log('🔄 Toggle sidebar - Currently:', isOpen ? 'open' : 'closed');
        
        if (isOpen) {
            // Close sidebar
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
            console.log('✅ Sidebar closed');
        } else {
            // Open sidebar
            sidebar.classList.add('show');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
            console.log('✅ Sidebar opened');
        }
    }
    
    // Use event delegation on document to catch all toggle button clicks
    document.addEventListener('click', function(e) {
        // Check if clicked element or its parent is a toggle button
        const toggleBtn = e.target.closest('.sidebar_toggle, [data-toggle="sidebar"], .fa-bars');
        
        if (toggleBtn) {
            console.log('🎯 Toggle button clicked via event delegation!', toggleBtn);
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
            return false;
        }
    });
    
    // Also bind directly for extra safety
    setTimeout(function() {
        const directToggleBtn = document.querySelector('.sidebar_toggle');
        if (directToggleBtn) {
            console.log('🔧 Direct binding to toggle button:', directToggleBtn);
            directToggleBtn.onclick = function(e) {
                console.log('🎯 Direct onclick triggered!');
                e.preventDefault();
                e.stopPropagation();
                toggleSidebar();
                return false;
            };
        }
    }, 500);
    
    // Bind close button
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('❌ Close button clicked');
            toggleSidebar();
        });
    }
    
    // Close on overlay click
    overlay.addEventListener('click', function() {
        console.log('🖱️ Overlay clicked');
        toggleSidebar();
    });
    
    // Handle submenu toggles
    const submenuToggles = document.querySelectorAll('.has-submenu');
    submenuToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            const isActive = this.classList.contains('active');
            
            // Close all other submenus
            submenuToggles.forEach(function(otherToggle) {
                if (otherToggle !== toggle) {
                    otherToggle.classList.remove('active');
                    const otherSubmenu = otherToggle.nextElementSibling;
                    if (otherSubmenu) {
                        otherSubmenu.classList.remove('show');
                    }
                }
            });
            
            // Toggle current submenu
            if (isActive) {
                this.classList.remove('active');
                submenu.classList.remove('show');
            } else {
                this.classList.add('active');
                submenu.classList.add('show');
            }
        });
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('show')) {
            toggleSidebar();
        }
    });
    
    // Global function for manual testing
    window.testSidebarToggle = function() {
        console.log('🧪 Manual test function called');
        toggleSidebar();
    };
    
    console.log('✅ Tree Sidebar 2.0 Initialized Successfully!');
    console.log('🧪 Test manually with: window.testSidebarToggle()');
});
</script>
