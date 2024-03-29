<?php
    header("Content-type: text/css; charset: UTF-8");

$toggle =  get_theme_mod('primary-menu'); 
if($toggle == 'Responsive'){ 
?>
.navbar-nav{
  margin: 0;
  font-family: "Vollkorn", Georgia, serif;
  font-weight: 300;
  text-rendering: optimizeLegibility;
  padding: 0;

}  

@media (min-width: 768px) {
  .navbar-right .dropdown-menu {
    right: 0;
    left: auto;
  }
  .nav-tabs.nav-justified > li {
    display: table-cell;
    width: 1%;
  }
  .nav-justified > li {
    display: table-cell;
    width: 1%;
  }
  .navbar {
    border-radius: 4px;
  }
  .navbar-header {
    float: left;
  }
  .navbar-collapse {
    width: auto;
    border-top: 0;
    box-shadow: none;
  }
  .navbar-collapse.collapse {
    display: block !important;
    height: auto !important;
    padding-bottom: 0;
    overflow: visible !important;
  }
  .navbar-collapse.in {
    overflow-y: visible;
  }
  .navbar-collapse .navbar-nav.navbar-left:first-child {
    margin-left: -15px;
  }
  .navbar-collapse .navbar-nav.navbar-right:last-child {
    margin-right: -15px;
  }
  .navbar-collapse .navbar-text:last-child {
    margin-right: 0;
  }
  .container > .navbar-header,
  .container > .navbar-collapse {
    margin-right: 0;
    margin-left: 0;
  }
  .navbar-static-top {
    border-radius: 0;
  }
  .navbar-fixed-top,
  .navbar-fixed-bottom {
    border-radius: 0;
  }
  .navbar > .container .navbar-brand {
    margin-left: -15px;
  }
  .navbar-toggle {
    display: none;
    position: relative;
    float: right !important;
    margin-right: 15px;
    padding: 9px 10px;
    margin-top: 16.5px;
    margin-bottom: 16.5px;
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: 4px;
  }    
  .navbar-nav {
    float: left;
    margin: 0;
  }
  .navbar-nav > li {
    float: left;
  }
  .navbar-nav > li > a {
    padding-top: 22px;
    padding-bottom: 22px;
    line-height: 1em;
    color: #545454;    
  }  
  .navbar-left {
    float: left;
    float: left !important;
  }
  .navbar-right {
    float: right;
    float: right !important;
  } 
  .navbar-form .form-group {
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle;
  }
  .navbar-form .form-control {
    display: inline-block;
  }
  .navbar-form .radio,
  .navbar-form .checkbox {
    display: inline-block;
    margin-top: 0;
    margin-bottom: 0;
    padding-left: 0;
  }
  .navbar-form .radio input[type="radio"],
  .navbar-form .checkbox input[type="checkbox"] {
    float: none;
    margin-left: 0;
  }
  .navbar-form {
    width: auto;
    border: 0;
    margin-left: 0;
    margin-right: 0;
    padding-top: 0;
    padding-bottom: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
  }  
  .navbar-text {
    margin-left: 15px;
    margin-right: 15px;
  }  
  .navbar-collapse {
    text-align:center;
    border-top: 1px solid transparent;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
    -webkit-overflow-scrolling: touch;
    background-color: rgba(0, 0, 0, 0.0);  
  }

}



@media (max-width: 767px) {
  .navbar-nav .open .dropdown-menu {
    position: static;
    float: none;
    width: auto;
    margin-top: 0;
    background-color: transparent;
    border: 0;
    box-shadow: none;
  }
  .navbar-nav .open .dropdown-menu > li > a,
  .navbar-nav .open .dropdown-menu .dropdown-header {
    padding: 5px 15px 5px 25px;
  }
  .navbar-nav .open .dropdown-menu > li > a {
    line-height: 23px;
  }
  .navbar-nav .open .dropdown-menu > li > a:hover,
  .navbar-nav .open .dropdown-menu > li > a:focus {
    background-image: none;
  }
  .navbar-form .form-group {
    margin-bottom: 5px;
  }  
  .navbar-collapse {
    text-align:center;
    border-top: 1px solid transparent;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
    -webkit-overflow-scrolling: touch;
    background-color: rgba(99, 183, 108, 0.95);  
    padding: 5% 0 ;
  }  
  .navbar-default .navbar-nav > li > a, .navbar-inverse .navbar-nav > li > a {
    line-height: 1em;
    color: #fff;
  }
}

<?php }else{ ?>

@media (min-width: 768px) {
  .navbar-right .dropdown-menu {
    right: 0;
    left: auto;
  }
  .nav-tabs.nav-justified > li {
    display: table-cell;
    width: 1%;
  }
  .nav-justified > li {
    display: table-cell;
    width: 1%;
  }
  .navbar {
    border-radius: 4px;
  }
  .navbar-header {
    float: left;
  }
  .navbar-collapse {
    width: auto;
    border-top: 0;
    box-shadow: none;
  }
  .navbar-collapse.collapse {
    display: block !important;
    height: auto !important;
    padding-bottom: 0;
    overflow: visible !important;
  }
  .navbar-collapse.in {
    overflow-y: visible;
  }
  .navbar-collapse .navbar-nav.navbar-left:first-child {
    margin-left: -15px;
  }
  .navbar-collapse .navbar-nav.navbar-right:last-child {
    margin-right: -15px;
  }
  .navbar-collapse .navbar-text:last-child {
    margin-right: 0;
  }
  .container > .navbar-header,
  .container > .navbar-collapse {
    margin-right: 0;
    margin-left: 0;
  }
  .navbar-static-top {
    border-radius: 0;
  }
  .navbar-fixed-top,
  .navbar-fixed-bottom {
    border-radius: 0;
  }
  .navbar > .container .navbar-brand {
    margin-left: -15px;
  }
  .navbar-toggle {
    display: none;
    position: relative;
    float: right !important;
    margin-right: 15px;
    padding: 9px 10px;
    margin-top: 16.5px;
    margin-bottom: 16.5px;
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: 4px;
  }    
  .navbar-nav {
    float: left;
    margin: 0;
  }
  .navbar-nav > li {
    float: left;
  }
  .navbar-nav > li > a {
    padding-top: 22px;
    padding-bottom: 22px;
    line-height: 1em;
    color: #545454;    
  }  
  .navbar-left {
    float: left;
    float: left !important;
  }
  .navbar-right {
    float: right;
    float: right !important;
  } 
  .navbar-form .form-group {
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle;
  }
  .navbar-form .form-control {
    display: inline-block;
  }
  .navbar-form .radio,
  .navbar-form .checkbox {
    display: inline-block;
    margin-top: 0;
    margin-bottom: 0;
    padding-left: 0;
  }
  .navbar-form .radio input[type="radio"],
  .navbar-form .checkbox input[type="checkbox"] {
    float: none;
    margin-left: 0;
  }
  .navbar-form {
    width: auto;
    border: 0;
    margin-left: 0;
    margin-right: 0;
    padding-top: 0;
    padding-bottom: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
  }  
  .navbar-text {
    margin-left: 15px;
    margin-right: 15px;
  }  
  .navbar-collapse {
    text-align:center;
    border-top: 1px solid transparent;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
    -webkit-overflow-scrolling: touch;
    background-color: rgba(0, 0, 0, 0.0);  
  }

}



@media (max-width: 767px) {
  .navbar-nav .open .dropdown-menu {
    position: static;
    float: none;
    width: auto;
    margin-top: 0;
    background-color: transparent;
    border: 0;
    box-shadow: none;
  }
  .navbar-nav .open .dropdown-menu > li > a,
  .navbar-nav .open .dropdown-menu .dropdown-header {
    padding: 5px 15px 5px 25px;
  }
  .navbar-nav .open .dropdown-menu > li > a {
    line-height: 23px;
  }
  .navbar-nav .open .dropdown-menu > li > a:hover,
  .navbar-nav .open .dropdown-menu > li > a:focus {
    background-image: none;
  }
  .navbar-form .form-group {
    margin-bottom: 5px;
  }  
  .navbar-collapse {
    text-align:center;
    border-top: 1px solid transparent;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
    -webkit-overflow-scrolling: touch;
    background-color: rgba(99, 183, 108, 0.95);  
    padding: 5% 0 ;
  }  
  .navbar-default .navbar-nav > li > a, .navbar-inverse .navbar-nav > li > a {
    line-height: 1em;
    color: #fff;
  }
}
<?php } ?>