
<style>
 .container-fluid {
	 width: 100%;
	 margin-right: auto;
	 margin-left: auto;
	 padding-right: 15px;
	 padding-left: 15px;
}
 .row1 {
	 display: flex;
	 margin-right: -15px;
	 margin-left: -15px;
	 flex-wrap: wrap;
}
.row {
	 margin-right: -15px;
	 margin-left: -15px;
}
 .col, .col-auto, .col-lg-6, .col-lg-12, .col-xl-3, .col-xl-6, .col-xl-12 {
	 position: relative;
	 width: 100%;
	 min-height: 1px;
	 padding-right: 15px;
	 padding-left: 15px;
}
 .col {
	 max-width: 100%;
	 flex-basis: 0;
	 flex-grow: 1;
}
 .col-auto {
	 width: auto;
	 max-width: none;
	 flex: 0 0 auto;
}
 @media (min-width: 992px) {
	 .col-lg-6 {
		 max-width: 50%;
		 flex: 0 0 50%;
	} 
	.col-lg-12 {
		 max-width: 100%;
		 flex: 0 0 100%;
	}
}
 @media (min-width: 1200px) {
	 .col-xl-3 {
		 max-width: 25%;
		 flex: 0 0 25%;
	}
	 .col-xl-6 {
		 max-width: 50%;
		 flex: 0 0 50%;
	}
	.col-xl-12 {
		 max-width: 100%;
		 flex: 0 0 100%;
	}
}
 .card {
	 position: relative;
	 display: flex;
	 flex-direction: column;
	 min-width: 0;
	 word-wrap: break-word;
	 border: 1px solid rgba(0, 0, 0, .05);
	 border-radius: 0.375rem;
	 background-color: #fff;
	 background-clip: border-box;
}
 .card-body {
	 padding: 1.5rem;
	 flex: 1 1 auto;
}
 .card-title {
	 margin-bottom: 1.25rem;
}
 @keyframes progress-bar-stripes {
	 from {
		 background-position: 1rem 0;
	}
	 to {
		 background-position: 0 0;
	}
}
 .bg-info {
	 background-color: #11cdef !important;
}
 a.bg-info:hover, a.bg-info:focus, button.bg-info:hover, button.bg-info:focus {
	 background-color: #0da5c0 !important;
}
 .bg-warning {
	 background-color: #fb6340 !important;
}
 a.bg-warning:hover, a.bg-warning:focus, button.bg-warning:hover, button.bg-warning:focus {
	 background-color: #fa3a0e !important;
}
 .bg-danger {
	 background-color: #f5365c !important;
}
 a.bg-danger:hover, a.bg-danger:focus, button.bg-danger:hover, button.bg-danger:focus {
	 background-color: #ec0c38 !important;
}
 .bg-default {
	 background-color: #172b4d !important;
}
 a.bg-default:hover, a.bg-default:focus, button.bg-default:hover, button.bg-default:focus {
	 background-color: #0b1526 !important;
}
 .rounded-circle {
	 border-radius: 50% !important;
}
 .align-items-center {
	 align-items: center !important;
}
 @media (min-width: 1200px) {
	 .justify-content-xl-between {
		 justify-content: space-between !important;
	}
}
 .shadow {
	 box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15) !important;
}
 .mb-0 {
	 margin-bottom: 0 !important;
}
 .mr-2 {
	 margin-right: 0.5rem !important;
}
 .mt-3 {
	 margin-top: 1rem !important;
}
 .mb-4 {
	 margin-bottom: 1.5rem !important;
}
 .mb-5 {
	 margin-bottom: 3rem !important;
}
 .pt-5 {
	 padding-top: 3rem !important;
}
 .pb-8 {
	 padding-bottom: 8rem !important;
}
 .m-auto {
	 margin: auto !important;
}
 @media (min-width: 768px) {
	 .pt-md-8 {
		 padding-top: 8rem !important;
	}
}
 @media (min-width: 1200px) {
	 .mb-xl-0 {
		 margin-bottom: 0 !important;
	}
}
 .text-nowrap {
	 white-space: nowrap !important;
}
 .text-center {
	 text-align: center !important;
}
 .text-uppercase {
	 text-transform: uppercase !important;
}
 .font-weight-bold {
	 font-weight: 600 !important;
}
 .text-white {
	 color: #fff !important;
}
 .text-success {
	 color: #2dce89 !important;
}
 a.text-success:hover, a.text-success:focus {
	 color: #24a46d !important;
}
 .text-warning {
	 color: #fb6340 !important;
}
 a.text-warning:hover, a.text-warning:focus {
	 color: #fa3a0e !important;
}
 .text-danger {
	 color: #f5365c !important;
}
 a.text-danger:hover, a.text-danger:focus {
	 color: #ec0c38 !important;
}
 .text-white {
	 color: #fff !important;
}
 a.text-white:hover, a.text-white:focus {
	 color: #e6e6e6 !important;
}
 .text-muted {
	 color: #8898aa !important;
}
 @media print {
	 *, *::before, *::after {
		 box-shadow: none !important;
		 text-shadow: none !important;
	}
	 a:not(.btn) {
		 text-decoration: underline;
	}
	 p, h2 {
		 orphans: 3;
		 widows: 3;
	}
	 h2 {
		 page-break-after: avoid;
	}
	 @page {
		 size: a3;
	}
}
 figcaption, main {
	 display: block;
}
 .bg-yellow {
	 background-color: #ffd600 !important;
}
.bg-green {
	 background-color: #234f1e !important;
}
 a.bg-yellow:hover, a.bg-yellow:focus, button.bg-yellow:hover, button.bg-yellow:focus {
	 background-color: #ccab00 !important;
}
 .bg-gradient-primary {
	 background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
}
 .bg-gradient-primary {
	 background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
}
 @keyframes floating-lg {
	 0% {
		 transform: translateY(0px);
	}
	 50% {
		 transform: translateY(15px);
	}
	 100% {
		 transform: translateY(0px);
	}
}
 @keyframes floating {
	 0% {
		 transform: translateY(0px);
	}
	 50% {
		 transform: translateY(10px);
	}
	 100% {
		 transform: translateY(0px);
	}
}
 @keyframes floating-sm {
	 0% {
		 transform: translateY(0px);
	}
	 50% {
		 transform: translateY(5px);
	}
	 100% {
		 transform: translateY(0px);
	}
}
 [class*='shadow'] {
	 transition: all 0.15s ease;
}
 .text-sm {
	 font-size: 0.875rem !important;
}
 .text-white {
	 color: #fff !important;
}
 a.text-white:hover, a.text-white:focus {
	 color: #e6e6e6 !important;
}
 [class*='btn-outline-'] {
	 border-width: 1px;
}
 .card-stats .card-body {
	 padding: 1rem 1.5rem;
}
 .main-content {
	 position: relative;
}
 @media (min-width: 768px) {
	 .main-content .container-fluid {
		 padding-right: 39px !important;
		 padding-left: 39px !important;
	}
}
 .icon {
	 width: 3rem;
	 height: 3rem;
}
 .icon i {
	 font-size: 2.25rem;
}
 .icon-shape {
	 display: inline-flex;
	 padding: 12px;
	 text-align: center;
	 border-radius: 50%;
	 align-items: center;
	 justify-content: center;
}
 .icon-shape i {
	 font-size: 1.25rem;
}
#map {
    height: 75%;
    width: 65%;
    }
  @media (max-width: 767px) {
     #map {
    height: 100%;
    width: 100%;
    }
    }
.legend {
  padding: 6px 8px;
  background: white;
  background: rgba(255, 255, 255, 0.8);
  /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
  /*border-radius: 5px;*/
  line-height: 24px;
  color: #555;
}
.legend h4 {
  text-align: center;
  font-size: 16px;
  margin: 2px 12px 8px;
  color: #777;
}

.legend span {
  position: relative;
  bottom: 3px;
}

.legend i {
  width: 18px;
  height: 18px;
  float: left;
  margin: 0 8px 0 0;
  opacity: 0.7;
}

.legend i.icon {
  background-size: 18px;
  background-color: rgba(255, 255, 255, 1);
}
</style>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet">

      <div class="container-fluid">
			<div class="col-xl-12">
          		@include('admin.tablevarietas')
          </div>
		</div>