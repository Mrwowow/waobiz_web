<style>
    /* Universal scrollbar hiding */

    /* Hide scrollbar for Chrome, Safari and Opera */
    html::-webkit-scrollbar,
    body::-webkit-scrollbar {
      display: none; /* Safari and Chrome */
    }

    /* Hide scrollbar for IE, Edge */
    html,
    body {
      -ms-overflow-style: none; /* IE and Edge */
      scrollbar-width: none; /* Firefox */
    }
  </style>

  

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <style>
    body {
      transition: opacity ease-in 0.2s;
    }
    body[unresolved] {
      opacity: 0;
      display: block;
      overflow: hidden;
      position: relative;
    }
  </style>
  <style type="text/css">
    .swal-icon--error {
      border-color: #f27474;
      -webkit-animation: animateErrorIcon 0.5s;
      animation: animateErrorIcon 0.5s;
    }
    .swal-icon--error__x-mark {
      position: relative;
      display: block;
      -webkit-animation: animateXMark 0.5s;
      animation: animateXMark 0.5s;
    }
    .swal-icon--error__line {
      position: absolute;
      height: 5px;
      width: 47px;
      background-color: #f27474;
      display: block;
      top: 37px;
      border-radius: 2px;
    }
    .swal-icon--error__line--left {
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
      left: 17px;
    }
    .swal-icon--error__line--right {
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      right: 16px;
    }
    @-webkit-keyframes animateErrorIcon {
      0% {
        -webkit-transform: rotateX(100deg);
        transform: rotateX(100deg);
        opacity: 0;
      }
      to {
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        opacity: 1;
      }
    }
    @keyframes animateErrorIcon {
      0% {
        -webkit-transform: rotateX(100deg);
        transform: rotateX(100deg);
        opacity: 0;
      }
      to {
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        opacity: 1;
      }
    }
    @-webkit-keyframes animateXMark {
      0% {
        -webkit-transform: scale(0.4);
        transform: scale(0.4);
        margin-top: 26px;
        opacity: 0;
      }
      50% {
        -webkit-transform: scale(0.4);
        transform: scale(0.4);
        margin-top: 26px;
        opacity: 0;
      }
      80% {
        -webkit-transform: scale(1.15);
        transform: scale(1.15);
        margin-top: -6px;
      }
      to {
        -webkit-transform: scale(1);
        transform: scale(1);
        margin-top: 0;
        opacity: 1;
      }
    }
    @keyframes animateXMark {
      0% {
        -webkit-transform: scale(0.4);
        transform: scale(0.4);
        margin-top: 26px;
        opacity: 0;
      }
      50% {
        -webkit-transform: scale(0.4);
        transform: scale(0.4);
        margin-top: 26px;
        opacity: 0;
      }
      80% {
        -webkit-transform: scale(1.15);
        transform: scale(1.15);
        margin-top: -6px;
      }
      to {
        -webkit-transform: scale(1);
        transform: scale(1);
        margin-top: 0;
        opacity: 1;
      }
    }
    .swal-icon--warning {
      border-color: #f8bb86;
      -webkit-animation: pulseWarning 0.75s infinite alternate;
      animation: pulseWarning 0.75s infinite alternate;
    }
    .swal-icon--warning__body {
      width: 5px;
      height: 47px;
      top: 10px;
      border-radius: 2px;
      margin-left: -2px;
    }
    .swal-icon--warning__body,
    .swal-icon--warning__dot {
      position: absolute;
      left: 50%;
      background-color: #f8bb86;
    }
    .swal-icon--warning__dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      margin-left: -4px;
      bottom: -11px;
    }
    @-webkit-keyframes pulseWarning {
      0% {
        border-color: #f8d486;
      }
      to {
        border-color: #f8bb86;
      }
    }
    @keyframes pulseWarning {
      0% {
        border-color: #f8d486;
      }
      to {
        border-color: #f8bb86;
      }
    }
    .swal-icon--success {
      border-color: #a5dc86;
    }
    .swal-icon--success:after,
    .swal-icon--success:before {
      content: "";
      border-radius: 50%;
      position: absolute;
      width: 60px;
      height: 120px;
      background: #fff;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
    }
    .swal-icon--success:before {
      border-radius: 120px 0 0 120px;
      top: -7px;
      left: -33px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 60px 60px;
      transform-origin: 60px 60px;
    }
    .swal-icon--success:after {
      border-radius: 0 120px 120px 0;
      top: -11px;
      left: 30px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 0 60px;
      transform-origin: 0 60px;
      -webkit-animation: rotatePlaceholder 4.25s ease-in;
      animation: rotatePlaceholder 4.25s ease-in;
    }
    .swal-icon--success__ring {
      width: 80px;
      height: 80px;
      border: 4px solid hsla(98, 55%, 69%, 0.2);
      border-radius: 50%;
      box-sizing: content-box;
      position: absolute;
      left: -4px;
      top: -4px;
      z-index: 2;
    }
    .swal-icon--success__hide-corners {
      width: 5px;
      height: 90px;
      background-color: #fff;
      padding: 1px;
      position: absolute;
      left: 28px;
      top: 8px;
      z-index: 1;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
    }
    .swal-icon--success__line {
      height: 5px;
      background-color: #a5dc86;
      display: block;
      border-radius: 2px;
      position: absolute;
      z-index: 2;
    }
    .swal-icon--success__line--tip {
      width: 25px;
      left: 14px;
      top: 46px;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
      -webkit-animation: animateSuccessTip 0.75s;
      animation: animateSuccessTip 0.75s;
    }
    .swal-icon--success__line--long {
      width: 47px;
      right: 8px;
      top: 38px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-animation: animateSuccessLong 0.75s;
      animation: animateSuccessLong 0.75s;
    }
    @-webkit-keyframes rotatePlaceholder {
      0% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
      }
      5% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
      }
      12% {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg);
      }
      to {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg);
      }
    }
    @keyframes rotatePlaceholder {
      0% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
      }
      5% {
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
      }
      12% {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg);
      }
      to {
        -webkit-transform: rotate(-405deg);
        transform: rotate(-405deg);
      }
    }
    @-webkit-keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px;
      }
      54% {
        width: 0;
        left: 1px;
        top: 19px;
      }
      70% {
        width: 50px;
        left: -8px;
        top: 37px;
      }
      84% {
        width: 17px;
        left: 21px;
        top: 48px;
      }
      to {
        width: 25px;
        left: 14px;
        top: 45px;
      }
    }
    @keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px;
      }
      54% {
        width: 0;
        left: 1px;
        top: 19px;
      }
      70% {
        width: 50px;
        left: -8px;
        top: 37px;
      }
      84% {
        width: 17px;
        left: 21px;
        top: 48px;
      }
      to {
        width: 25px;
        left: 14px;
        top: 45px;
      }
    }
    @-webkit-keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px;
      }
      65% {
        width: 0;
        right: 46px;
        top: 54px;
      }
      84% {
        width: 55px;
        right: 0;
        top: 35px;
      }
      to {
        width: 47px;
        right: 8px;
        top: 38px;
      }
    }
    @keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px;
      }
      65% {
        width: 0;
        right: 46px;
        top: 54px;
      }
      84% {
        width: 55px;
        right: 0;
        top: 35px;
      }
      to {
        width: 47px;
        right: 8px;
        top: 38px;
      }
    }
    .swal-icon--info {
      border-color: #c9dae1;
    }
    .swal-icon--info:before {
      width: 5px;
      height: 29px;
      bottom: 17px;
      border-radius: 2px;
      margin-left: -2px;
    }
    .swal-icon--info:after,
    .swal-icon--info:before {
      content: "";
      position: absolute;
      left: 50%;
      background-color: #c9dae1;
    }
    .swal-icon--info:after {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      margin-left: -3px;
      top: 19px;
    }
    .swal-icon {
      width: 80px;
      height: 80px;
      border-width: 4px;
      border-style: solid;
      border-radius: 50%;
      padding: 0;
      position: relative;
      box-sizing: content-box;
      margin: 20px auto;
    }
    .swal-icon:first-child {
      margin-top: 32px;
    }
    .swal-icon--custom {
      width: auto;
      height: auto;
      max-width: 100%;
      border: none;
      border-radius: 0;
    }
    .swal-icon img {
      max-width: 100%;
      max-height: 100%;
    }
    .swal-title {
      color: rgba(0, 0, 0, 0.65);
      font-weight: 600;
      text-transform: none;
      position: relative;
      display: block;
      padding: 13px 16px;
      font-size: 27px;
      line-height: normal;
      text-align: center;
      margin-bottom: 0;
    }
    .swal-title:first-child {
      margin-top: 26px;
    }
    .swal-title:not(:first-child) {
      padding-bottom: 0;
    }
    .swal-title:not(:last-child) {
      margin-bottom: 13px;
    }
    .swal-text {
      font-size: 16px;
      position: relative;
      float: none;
      line-height: normal;
      vertical-align: top;
      text-align: left;
      display: inline-block;
      margin: 0;
      padding: 0 10px;
      font-weight: 400;
      color: rgba(0, 0, 0, 0.64);
      max-width: calc(100% - 20px);
      overflow-wrap: break-word;
      box-sizing: border-box;
    }
    .swal-text:first-child {
      margin-top: 45px;
    }
    .swal-text:last-child {
      margin-bottom: 45px;
    }
    .swal-footer {
      text-align: right;
      padding-top: 13px;
      margin-top: 13px;
      padding: 13px 16px;
      border-radius: inherit;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }
    .swal-button-container {
      margin: 5px;
      display: inline-block;
      position: relative;
    }
    .swal-button {
      background-color: #7cd1f9;
      color: #fff;
      border: none;
      box-shadow: none;
      border-radius: 5px;
      font-weight: 600;
      font-size: 14px;
      padding: 10px 24px;
      margin: 0;
      cursor: pointer;
    }
    .swal-button[not:disabled]:hover {
      background-color: #78cbf2;
    }
    .swal-button:active {
      background-color: #70bce0;
    }
    .swal-button:focus {
      outline: none;
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(43, 114, 165, 0.29);
    }
    .swal-button[disabled] {
      opacity: 0.5;
      cursor: default;
    }
    .swal-button::-moz-focus-inner {
      border: 0;
    }
    .swal-button--cancel {
      color: #555;
      background-color: #efefef;
    }
    .swal-button--cancel[not:disabled]:hover {
      background-color: #e8e8e8;
    }
    .swal-button--cancel:active {
      background-color: #d7d7d7;
    }
    .swal-button--cancel:focus {
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(116, 136, 150, 0.29);
    }
    .swal-button--danger {
      background-color: #e64942;
    }
    .swal-button--danger[not:disabled]:hover {
      background-color: #df4740;
    }
    .swal-button--danger:active {
      background-color: #cf423b;
    }
    .swal-button--danger:focus {
      box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(165, 43, 43, 0.29);
    }
    .swal-content {
      padding: 0 20px;
      margin-top: 20px;
      font-size: medium;
    }
    .swal-content:last-child {
      margin-bottom: 20px;
    }
    .swal-content__input,
    .swal-content__textarea {
      -webkit-appearance: none;
      background-color: #fff;
      border: none;
      font-size: 14px;
      display: block;
      box-sizing: border-box;
      width: 100%;
      border: 1px solid rgba(0, 0, 0, 0.14);
      padding: 10px 13px;
      border-radius: 2px;
      transition: border-color 0.2s;
    }
    .swal-content__input:focus,
    .swal-content__textarea:focus {
      outline: none;
      border-color: #6db8ff;
    }
    .swal-content__textarea {
      resize: vertical;
    }
    .swal-button--loading {
      color: transparent;
    }
    .swal-button--loading ~ .swal-button__loader {
      opacity: 1;
    }
    .swal-button__loader {
      position: absolute;
      height: auto;
      width: 43px;
      z-index: 2;
      left: 50%;
      top: 50%;
      -webkit-transform: translateX(-50%) translateY(-50%);
      transform: translateX(-50%) translateY(-50%);
      text-align: center;
      pointer-events: none;
      opacity: 0;
    }
    .swal-button__loader div {
      display: inline-block;
      float: none;
      vertical-align: baseline;
      width: 9px;
      height: 9px;
      padding: 0;
      border: none;
      margin: 2px;
      opacity: 0.4;
      border-radius: 7px;
      background-color: hsla(0, 0%, 100%, 0.9);
      transition: background 0.2s;
      -webkit-animation: swal-loading-anim 1s infinite;
      animation: swal-loading-anim 1s infinite;
    }
    .swal-button__loader div:nth-child(3n + 2) {
      -webkit-animation-delay: 0.15s;
      animation-delay: 0.15s;
    }
    .swal-button__loader div:nth-child(3n + 3) {
      -webkit-animation-delay: 0.3s;
      animation-delay: 0.3s;
    }
    @-webkit-keyframes swal-loading-anim {
      0% {
        opacity: 0.4;
      }
      20% {
        opacity: 0.4;
      }
      50% {
        opacity: 1;
      }
      to {
        opacity: 0.4;
      }
    }
    @keyframes swal-loading-anim {
      0% {
        opacity: 0.4;
      }
      20% {
        opacity: 0.4;
      }
      50% {
        opacity: 1;
      }
      to {
        opacity: 0.4;
      }
    }
    .swal-overlay {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 0;
      overflow-y: auto;
      background-color: rgba(0, 0, 0, 0.4);
      z-index: 10000;
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.3s;
    }
    .swal-overlay:before {
      content: " ";
      display: inline-block;
      vertical-align: middle;
      height: 100%;
    }
    .swal-overlay--show-modal {
      opacity: 1;
      pointer-events: auto;
    }
    .swal-overlay--show-modal .swal-modal {
      opacity: 1;
      pointer-events: auto;
      box-sizing: border-box;
      -webkit-animation: showSweetAlert 0.3s;
      animation: showSweetAlert 0.3s;
      will-change: transform;
    }
    .swal-modal {
      width: 478px;
      opacity: 0;
      pointer-events: none;
      background-color: #fff;
      text-align: center;
      border-radius: 5px;
      position: static;
      margin: 20px auto;
      display: inline-block;
      vertical-align: middle;
      -webkit-transform: scale(1);
      transform: scale(1);
      -webkit-transform-origin: 50% 50%;
      transform-origin: 50% 50%;
      z-index: 10001;
      transition: opacity 0.2s, -webkit-transform 0.3s;
      transition: transform 0.3s, opacity 0.2s;
      transition: transform 0.3s, opacity 0.2s, -webkit-transform 0.3s;
    }
    @media (max-width: 500px) {
      .swal-modal {
        width: calc(100% - 20px);
      }
    }
    @-webkit-keyframes showSweetAlert {
      0% {
        -webkit-transform: scale(1);
        transform: scale(1);
      }
      1% {
        -webkit-transform: scale(0.5);
        transform: scale(0.5);
      }
      45% {
        -webkit-transform: scale(1.05);
        transform: scale(1.05);
      }
      80% {
        -webkit-transform: scale(0.95);
        transform: scale(0.95);
      }
      to {
        -webkit-transform: scale(1);
        transform: scale(1);
      }
    }
    @keyframes showSweetAlert {
      0% {
        -webkit-transform: scale(1);
        transform: scale(1);
      }
      1% {
        -webkit-transform: scale(0.5);
        transform: scale(0.5);
      }
      45% {
        -webkit-transform: scale(1.05);
        transform: scale(1.05);
      }
      80% {
        -webkit-transform: scale(0.95);
        transform: scale(0.95);
      }
      to {
        -webkit-transform: scale(1);
        transform: scale(1);
      }
    }
  </style>
  <style>
    .action-link[data-v-1552a5b6] {
      cursor: pointer;
    }
  </style>
  <style>
    .action-link[data-v-397d14ca] {
      cursor: pointer;
    }
  </style>
  <style>
    .action-link[data-v-49962cc0] {
      cursor: pointer;
    }
  </style>

  <!-- Modern Dashboard Styles -->
  <style>
    :root {
      --primary-orange: #FF9500;
      --primary-orange-dark: #E68600;
      --primary-orange-light: #FFB347;
      --dark-bg: #0a0a0a;
      --dark-secondary: #1a1a1a;
      --dark-tertiary: #2a2a2a;
    }

    /* Modern Stat Cards */
    .tw-bg-white.tw-shadow-sm.tw-rounded-xl {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
      border: 1px solid rgba(0, 0, 0, 0.06) !important;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
    }

    .tw-bg-white.tw-shadow-sm.tw-rounded-xl:hover {
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
      border-color: rgba(255, 149, 0, 0.2) !important;
    }

    /* Orange gradient backgrounds for dashboard header */
    .tw-bg-gradient-to-r.tw-from-primary-800,
    [class*="tw-from-primary-800"] {
      background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%) !important;
    }

    /* Icon backgrounds with orange accents */
    .tw-bg-sky-100 {
      background: linear-gradient(135deg, rgba(255, 149, 0, 0.15) 0%, rgba(255, 149, 0, 0.08) 100%) !important;
    }

    .tw-text-sky-500 {
      color: #FF9500 !important;
    }

    .tw-bg-green-100 {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.08) 100%) !important;
    }

    .tw-bg-yellow-100 {
      background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.08) 100%) !important;
    }

    .tw-bg-red-100 {
      background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.08) 100%) !important;
    }

    /* Modern buttons */
    .btn-primary,
    .btn-success {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      border-color: #E68600 !important;
      color: #000 !important;
      box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
      transition: all 0.2s ease;
    }

    .btn-primary:hover,
    .btn-success:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4);
      color: #000 !important;
    }

    .btn-primary:focus,
    .btn-success:focus {
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.2) !important;
    }

    /* Date filter button */
    #dashboard_date_filter {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
      border: 1px solid rgba(0, 0, 0, 0.1) !important;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    #dashboard_date_filter:hover {
      border-color: rgba(255, 149, 0, 0.3) !important;
      color: #FF9500 !important;
    }

    /* Table styling */
    .table-bordered {
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid rgba(0, 0, 0, 0.08) !important;
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
      background-color: rgba(248, 250, 252, 0.5);
    }

    .table-striped > tbody > tr:hover {
      background-color: rgba(255, 149, 0, 0.05);
    }

    .table thead th {
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      border-bottom: 2px solid rgba(255, 149, 0, 0.2) !important;
      font-weight: 600;
      color: #374151;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.05em;
    }

    /* Chart containers */
    .tw-border-dashed.tw-rounded-xl {
      border-color: rgba(255, 149, 0, 0.2) !important;
      background: linear-gradient(135deg, rgba(255, 149, 0, 0.02) 0%, rgba(255, 149, 0, 0.01) 100%) !important;
    }

    /* Section headers with icons */
    .tw-border-2.tw-rounded-full {
      border-color: rgba(255, 149, 0, 0.3) !important;
      background: rgba(255, 149, 0, 0.05) !important;
    }

    /* Select2 styling */
    .select2-container--default .select2-selection--single {
      border-radius: 10px !important;
      border: 1px solid rgba(0, 0, 0, 0.1) !important;
      height: 40px !important;
      padding: 5px 10px;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--focus .select2-selection--single {
      border-color: #FF9500 !important;
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.1) !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
      background-color: #FF9500 !important;
    }

    /* Form controls */
    .form-control:focus {
      border-color: #FF9500 !important;
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.1) !important;
    }

    /* DataTables pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      border-color: #E68600 !important;
      color: #000 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: rgba(255, 149, 0, 0.1) !important;
      border-color: rgba(255, 149, 0, 0.3) !important;
      color: #FF9500 !important;
    }

    /* Labels and badges */
    .label-success,
    .badge-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    }

    .label-primary,
    .badge-primary {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000 !important;
    }

    .label-warning,
    .badge-warning {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }

    .label-danger,
    .badge-danger {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    }

    /* Welcome message styling */
    h1.tw-text-2xl,
    h1.tw-text-4xl {
      background: linear-gradient(135deg, #ffffff 0%, rgba(255, 149, 0, 0.9) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Footer styling */
    .main-footer {
      background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%) !important;
      border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
      color: #94a3b8 !important;
    }

    .main-footer a {
      color: #FF9500 !important;
    }

    /* Scrollbar styling */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
      background: rgba(255, 149, 0, 0.3);
      border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 149, 0, 0.5);
    }

    /* Loading spinner */
    .loading-spinner {
      border: 3px solid rgba(255, 149, 0, 0.1);
      border-top-color: #FF9500;
    }

    /* Alert boxes */
    .alert-success {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
      border-color: rgba(16, 185, 129, 0.3);
      color: #059669;
    }

    .alert-info {
      background: linear-gradient(135deg, rgba(255, 149, 0, 0.1) 0%, rgba(255, 149, 0, 0.05) 100%);
      border-color: rgba(255, 149, 0, 0.3);
      color: #E68600;
    }

    .alert-warning {
      background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%);
      border-color: rgba(245, 158, 11, 0.3);
      color: #d97706;
    }

    .alert-danger {
      background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
      border-color: rgba(239, 68, 68, 0.3);
      color: #dc2626;
    }

    /* Modal styling */
    .modal-content {
      border-radius: 16px;
      border: 1px solid rgba(0, 0, 0, 0.08);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      border-radius: 16px 16px 0 0;
    }

    .modal-footer {
      border-top: 1px solid rgba(0, 0, 0, 0.06);
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      border-radius: 0 0 16px 16px;
    }

    /* Dropdown menus */
    .dropdown-menu {
      border-radius: 12px;
      border: 1px solid rgba(0, 0, 0, 0.08);
      box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
    }

    .dropdown-menu > li > a:hover {
      background: rgba(255, 149, 0, 0.1);
      color: #FF9500;
    }

    /* Tooltips */
    .tooltip-inner {
      background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
      border-radius: 8px;
    }

    .tooltip.top .tooltip-arrow {
      border-top-color: #0a0a0a;
    }

    /* Progress bars */
    .progress-bar {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%);
    }

    /* Toastr notifications */
    .toast-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    }

    .toast-info {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
    }

    .toast-warning {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }

    .toast-error {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    }

    /* ======================================
       DARK THEME - CRM STYLE
       ====================================== */

    /* ======================================
       DARK STAT CARDS
       ====================================== */

    /* Stat card containers - Dark theme */
    .tw-bg-white.tw-shadow-sm.tw-rounded-xl,
    .tw-bg-white.tw-rounded-xl,
    [class*="stat-card"],
    .tw-p-4.tw-bg-white,
    .box,
    .info-box,
    .small-box {
      background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
      border: 1px solid rgba(255, 255, 255, 0.06) !important;
      border-radius: 16px !important;
      box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.3),
                  0 0 0 1px rgba(255, 149, 0, 0.02) !important;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
      overflow: hidden;
    }

    .tw-bg-white.tw-shadow-sm.tw-rounded-xl:hover,
    .tw-bg-white.tw-rounded-xl:hover,
    .tw-p-4.tw-bg-white:hover,
    .box:hover,
    .info-box:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 12px 40px -8px rgba(255, 149, 0, 0.2),
                  0 0 0 1px rgba(255, 149, 0, 0.15) !important;
      border-color: rgba(255, 149, 0, 0.2) !important;
    }

    /* Stat card icons - different colors for different stats */
    .tw-p-2.tw-rounded-xl.tw-bg-sky-100,
    .tw-p-2.tw-rounded-xl[class*="bg-"] {
      width: 52px !important;
      height: 52px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      border-radius: 14px !important;
    }

    /* Total Sales icon */
    .tw-bg-sky-100 {
      background: linear-gradient(135deg, rgba(255, 149, 0, 0.2) 0%, rgba(255, 149, 0, 0.08) 100%) !important;
    }
    .tw-bg-sky-100 svg,
    .tw-text-sky-500 {
      color: #FF9500 !important;
    }

    /* Net icon - green */
    .tw-bg-green-100 {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.08) 100%) !important;
    }
    .tw-bg-green-100 svg,
    .tw-text-green-500 {
      color: #10b981 !important;
    }

    /* Invoice due icon - yellow/amber */
    .tw-bg-yellow-100,
    .tw-bg-amber-100 {
      background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.08) 100%) !important;
    }
    .tw-bg-yellow-100 svg,
    .tw-bg-amber-100 svg,
    .tw-text-yellow-500,
    .tw-text-amber-500 {
      color: #f59e0b !important;
    }

    /* Return/Expense icon - red/pink */
    .tw-bg-red-100,
    .tw-bg-pink-100 {
      background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(239, 68, 68, 0.08) 100%) !important;
    }
    .tw-bg-red-100 svg,
    .tw-bg-pink-100 svg,
    .tw-text-red-500,
    .tw-text-pink-500 {
      color: #ef4444 !important;
    }

    /* Purple icons */
    .tw-bg-purple-100 {
      background: linear-gradient(135deg, rgba(168, 85, 247, 0.2) 0%, rgba(168, 85, 247, 0.08) 100%) !important;
    }
    .tw-bg-purple-100 svg,
    .tw-text-purple-500 {
      color: #a855f7 !important;
    }

    /* Stat card values - Light text on dark */
    .tw-text-2xl.tw-font-bold,
    .tw-text-xl.tw-font-bold,
    h3.tw-font-bold,
    .info-box-number {
      color: #ffffff !important;
      font-weight: 700 !important;
    }

    /* Stat card labels - Muted text */
    .tw-text-gray-500,
    .tw-text-sm.tw-text-gray-500,
    .info-box-text {
      color: #9ca3af !important;
      font-weight: 500 !important;
    }

    /* ======================================
       DARK CHARTS & GRAPHS
       ====================================== */

    /* Chart containers */
    .tw-border.tw-border-dashed.tw-rounded-xl,
    [class*="chart-container"],
    .highcharts-container,
    .chart-box,
    .box-body {
      background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
      border: 1px solid rgba(255, 255, 255, 0.06) !important;
      border-radius: 16px !important;
      box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.3) !important;
    }

    /* Chart section headers */
    .tw-flex.tw-items-center.tw-gap-3 h2,
    .tw-text-lg.tw-font-semibold,
    .box-title {
      color: #ffffff !important;
      font-weight: 600 !important;
    }

    /* Chart header icons */
    .tw-p-2.tw-border-2.tw-rounded-full {
      border-color: rgba(255, 149, 0, 0.3) !important;
      background: rgba(255, 149, 0, 0.1) !important;
    }

    .tw-p-2.tw-border-2.tw-rounded-full svg {
      color: #FF9500 !important;
    }

    /* Highcharts dark theme */
    .highcharts-background {
      fill: transparent !important;
    }

    .highcharts-title,
    .highcharts-subtitle {
      fill: #ffffff !important;
    }

    .highcharts-axis-labels text,
    .highcharts-legend-item text {
      fill: #9ca3af !important;
    }

    .highcharts-grid-line {
      stroke: rgba(255, 255, 255, 0.06) !important;
    }

    /* ======================================
       DARK TABLES - ENHANCED VISIBILITY
       ====================================== */

    /* Table container wrapper */
    .table-responsive,
    .dataTables_wrapper,
    div[class*="table"] {
      background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
      border-radius: 16px !important;
      border: 1px solid rgba(255, 255, 255, 0.08) !important;
      padding: 1rem !important;
      overflow-x: auto !important;
    }

    /* Base table styles */
    table,
    .table,
    .dataTable {
      background: transparent !important;
      color: #ffffff !important;
      width: 100% !important;
      border-collapse: separate !important;
      border-spacing: 0 !important;
    }

    /* Table header - Dark with better contrast */
    table thead th,
    .table thead th,
    .dataTable thead th,
    .table-bordered thead th {
      background: rgba(255, 149, 0, 0.1) !important;
      color: #FF9500 !important;
      border: none !important;
      border-bottom: 2px solid rgba(255, 149, 0, 0.3) !important;
      font-weight: 700 !important;
      text-transform: uppercase !important;
      font-size: 0.7rem !important;
      letter-spacing: 0.08em !important;
      padding: 14px 12px !important;
      white-space: nowrap !important;
      vertical-align: middle !important;
    }

    /* Sortable column indicators */
    table thead th.sorting,
    table thead th.sorting_asc,
    table thead th.sorting_desc {
      cursor: pointer !important;
      position: relative !important;
    }

    table thead th.sorting_asc::after {
      content: " ▲" !important;
      font-size: 0.6rem !important;
      color: #FF9500 !important;
    }

    table thead th.sorting_desc::after {
      content: " ▼" !important;
      font-size: 0.6rem !important;
      color: #FF9500 !important;
    }

    /* Table body rows */
    table tbody tr,
    .table tbody tr,
    .dataTable tbody tr {
      background: rgba(255, 255, 255, 0.02) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
      transition: all 0.2s ease !important;
    }

    /* Alternating row colors for better readability */
    table tbody tr:nth-child(even),
    .table tbody tr:nth-child(even),
    .dataTable tbody tr:nth-child(even) {
      background: rgba(255, 255, 255, 0.04) !important;
    }

    /* Row hover effect */
    table tbody tr:hover,
    .table tbody tr:hover,
    .dataTable tbody tr:hover {
      background: rgba(255, 149, 0, 0.12) !important;
      transform: scale(1.002) !important;
    }

    /* Table cells - High contrast text */
    table tbody td,
    .table tbody td,
    .dataTable tbody td {
      color: #ffffff !important;
      border: none !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
      padding: 14px 12px !important;
      font-size: 0.875rem !important;
      font-weight: 400 !important;
      vertical-align: middle !important;
    }

    /* Product/Item names - Bold and visible */
    table tbody td:nth-child(3),
    table tbody td:nth-child(4),
    .dataTable tbody td a {
      color: #ffffff !important;
      font-weight: 600 !important;
    }

    /* Links in table */
    table tbody td a,
    .table tbody td a,
    .dataTable tbody td a {
      color: #FF9500 !important;
      text-decoration: none !important;
      font-weight: 500 !important;
      transition: all 0.2s ease !important;
    }

    table tbody td a:hover,
    .table tbody td a:hover,
    .dataTable tbody td a:hover {
      color: #FFB347 !important;
      text-decoration: underline !important;
    }

    /* Numeric values - Better visibility */
    table tbody td[class*="price"],
    table tbody td[class*="amount"],
    table tbody td[class*="stock"],
    table tbody td:nth-child(n+5) {
      color: #e5e7eb !important;
      font-family: 'SF Mono', 'Monaco', 'Consolas', monospace !important;
      font-weight: 500 !important;
    }

    /* Image cells */
    table tbody td img,
    .dataTable tbody td img {
      border-radius: 8px !important;
      border: 2px solid rgba(255, 255, 255, 0.1) !important;
      max-width: 60px !important;
      height: auto !important;
    }

    /* Action buttons in table */
    table tbody td .btn,
    table tbody td .dropdown-toggle,
    .dataTable tbody td .btn {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-radius: 8px !important;
      padding: 6px 14px !important;
      font-size: 0.75rem !important;
      font-weight: 600 !important;
      box-shadow: 0 2px 8px rgba(255, 149, 0, 0.3) !important;
      transition: all 0.2s ease !important;
    }

    table tbody td .btn:hover,
    table tbody td .dropdown-toggle:hover {
      transform: translateY(-1px) !important;
      box-shadow: 0 4px 12px rgba(255, 149, 0, 0.4) !important;
    }

    /* Dropdown menu in table */
    table tbody .dropdown-menu,
    .dataTable tbody .dropdown-menu {
      background: #1e1e36 !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 10px !important;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4) !important;
    }

    table tbody .dropdown-menu li a,
    .dataTable tbody .dropdown-menu li a {
      color: #e5e7eb !important;
      padding: 10px 16px !important;
    }

    table tbody .dropdown-menu li a:hover {
      background: rgba(255, 149, 0, 0.15) !important;
      color: #FF9500 !important;
    }

    /* Checkbox styling in tables */
    table tbody td input[type="checkbox"],
    .dataTable tbody td input[type="checkbox"] {
      width: 18px !important;
      height: 18px !important;
      accent-color: #FF9500 !important;
      cursor: pointer !important;
    }

    /* ======================================
       DATATABLE CONTROLS - ENHANCED
       ====================================== */

    /* DataTables wrapper header */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
      margin-bottom: 1rem !important;
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
      color: #9ca3af !important;
      font-size: 0.875rem !important;
      font-weight: 500 !important;
    }

    /* Length selector dropdown */
    .dataTables_wrapper .dataTables_length select {
      background: rgba(255, 255, 255, 0.08) !important;
      border: 1px solid rgba(255, 255, 255, 0.15) !important;
      color: #ffffff !important;
      border-radius: 8px !important;
      padding: 8px 12px !important;
      font-size: 0.875rem !important;
      margin: 0 8px !important;
    }

    .dataTables_wrapper .dataTables_length select:focus {
      border-color: #FF9500 !important;
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.15) !important;
      outline: none !important;
    }

    /* Search input */
    .dataTables_wrapper .dataTables_filter input {
      background: rgba(255, 255, 255, 0.08) !important;
      border: 1px solid rgba(255, 255, 255, 0.15) !important;
      color: #ffffff !important;
      border-radius: 10px !important;
      padding: 10px 16px !important;
      font-size: 0.875rem !important;
      min-width: 200px !important;
      transition: all 0.2s ease !important;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
      border-color: #FF9500 !important;
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.15) !important;
      outline: none !important;
      background: rgba(255, 255, 255, 0.1) !important;
    }

    .dataTables_wrapper .dataTables_filter input::placeholder {
      color: #6b7280 !important;
    }

    /* Pagination */
    .dataTables_wrapper .dataTables_paginate {
      margin-top: 1.5rem !important;
      padding-top: 1rem !important;
      border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      background: rgba(255, 255, 255, 0.06) !important;
      border: 1px solid rgba(255, 255, 255, 0.12) !important;
      color: #9ca3af !important;
      border-radius: 8px !important;
      padding: 8px 14px !important;
      margin: 0 3px !important;
      font-size: 0.8125rem !important;
      font-weight: 500 !important;
      transition: all 0.2s ease !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: rgba(255, 149, 0, 0.2) !important;
      border-color: rgba(255, 149, 0, 0.4) !important;
      color: #FF9500 !important;
      transform: translateY(-1px) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      border-color: #FF9500 !important;
      color: #000000 !important;
      font-weight: 700 !important;
      box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
      background: rgba(255, 255, 255, 0.02) !important;
      border-color: rgba(255, 255, 255, 0.05) !important;
      color: #4b5563 !important;
      cursor: not-allowed !important;
      opacity: 0.5 !important;
    }

    /* Info text */
    .dataTables_wrapper .dataTables_info {
      color: #6b7280 !important;
      font-size: 0.8125rem !important;
      padding-top: 1rem !important;
    }

    /* ======================================
       TABLE EXPORT BUTTONS
       ====================================== */

    .dt-buttons,
    .buttons-html5,
    .buttons-print {
      margin-bottom: 1rem !important;
    }

    .dt-buttons .btn,
    .buttons-csv,
    .buttons-excel,
    .buttons-pdf,
    .buttons-print,
    .buttons-copy {
      background: rgba(255, 255, 255, 0.08) !important;
      border: 1px solid rgba(255, 255, 255, 0.15) !important;
      color: #e5e7eb !important;
      border-radius: 8px !important;
      padding: 8px 16px !important;
      font-size: 0.8125rem !important;
      font-weight: 500 !important;
      margin-right: 8px !important;
      transition: all 0.2s ease !important;
    }

    .dt-buttons .btn:hover,
    .buttons-csv:hover,
    .buttons-excel:hover,
    .buttons-pdf:hover,
    .buttons-print:hover {
      background: rgba(255, 149, 0, 0.15) !important;
      border-color: rgba(255, 149, 0, 0.3) !important;
      color: #FF9500 !important;
    }

    /* ======================================
       MOBILE RESPONSIVE TABLES
       ====================================== */

    @media (max-width: 1024px) {
      .table-responsive,
      .dataTables_wrapper {
        padding: 0.75rem !important;
        border-radius: 12px !important;
      }

      table thead th,
      .dataTable thead th {
        padding: 10px 8px !important;
        font-size: 0.65rem !important;
      }

      table tbody td,
      .dataTable tbody td {
        padding: 10px 8px !important;
        font-size: 0.8rem !important;
      }

      .dataTables_wrapper .dataTables_filter input {
        min-width: 150px !important;
        padding: 8px 12px !important;
      }
    }

    @media (max-width: 768px) {
      /* Stack controls on mobile */
      .dataTables_wrapper .dataTables_length,
      .dataTables_wrapper .dataTables_filter {
        float: none !important;
        text-align: left !important;
        width: 100% !important;
        margin-bottom: 0.75rem !important;
      }

      .dataTables_wrapper .dataTables_filter input {
        width: 100% !important;
        min-width: unset !important;
      }

      .dataTables_wrapper .dataTables_info,
      .dataTables_wrapper .dataTables_paginate {
        float: none !important;
        text-align: center !important;
        width: 100% !important;
      }

      /* Smaller table text on mobile */
      table thead th {
        padding: 8px 6px !important;
        font-size: 0.6rem !important;
        letter-spacing: 0.03em !important;
      }

      table tbody td {
        padding: 8px 6px !important;
        font-size: 0.75rem !important;
      }

      /* Hide less important columns on mobile */
      table thead th:nth-child(n+7),
      table tbody td:nth-child(n+7) {
        display: none !important;
      }

      /* Smaller action buttons */
      table tbody td .btn {
        padding: 4px 10px !important;
        font-size: 0.7rem !important;
      }

      /* Pagination adjustments */
      .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 6px 10px !important;
        font-size: 0.75rem !important;
        margin: 2px !important;
      }

      /* Export buttons wrap */
      .dt-buttons {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 6px !important;
      }

      .dt-buttons .btn {
        padding: 6px 12px !important;
        font-size: 0.75rem !important;
        margin-right: 0 !important;
      }
    }

    @media (max-width: 480px) {
      .table-responsive,
      .dataTables_wrapper {
        padding: 0.5rem !important;
        margin: 0 -0.5rem !important;
        border-radius: 0 !important;
        border-left: none !important;
        border-right: none !important;
      }

      table thead th {
        padding: 6px 4px !important;
        font-size: 0.55rem !important;
      }

      table tbody td {
        padding: 6px 4px !important;
        font-size: 0.7rem !important;
      }

      /* Show only essential columns on very small screens */
      table thead th:nth-child(n+5),
      table tbody td:nth-child(n+5) {
        display: none !important;
      }

      /* Keep checkbox and first few columns */
      table thead th:first-child,
      table tbody td:first-child,
      table thead th:nth-child(2),
      table tbody td:nth-child(2),
      table thead th:nth-child(3),
      table tbody td:nth-child(3),
      table thead th:nth-child(4),
      table tbody td:nth-child(4) {
        display: table-cell !important;
      }

      /* Make images smaller */
      table tbody td img {
        max-width: 40px !important;
      }

      /* Stack pagination */
      .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 8px !important;
        font-size: 0.7rem !important;
      }
    }

    /* ======================================
       TABLE EMPTY STATE
       ====================================== */

    .dataTables_empty,
    table tbody tr.odd td.dataTables_empty {
      text-align: center !important;
      padding: 3rem 1rem !important;
      color: #6b7280 !important;
      font-size: 0.9rem !important;
      background: rgba(255, 255, 255, 0.02) !important;
    }

    /* ======================================
       SELECTED ROWS
       ====================================== */

    table tbody tr.selected,
    .dataTable tbody tr.selected {
      background: rgba(255, 149, 0, 0.15) !important;
    }

    table tbody tr.selected td {
      color: #FF9500 !important;
      font-weight: 500 !important;
    }

    /* ======================================
       DARK FORMS
       ====================================== */

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    input[type="date"],
    input[type="datetime-local"],
    input[type="search"],
    textarea,
    select,
    .form-control,
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
      background: rgba(255, 255, 255, 0.05) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      color: #e5e7eb !important;
      border-radius: 10px !important;
      transition: all 0.2s ease !important;
    }

    input:focus,
    textarea:focus,
    select:focus,
    .form-control:focus {
      background: rgba(255, 255, 255, 0.08) !important;
      border-color: rgba(255, 149, 0, 0.4) !important;
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.1) !important;
      outline: none !important;
    }

    input::placeholder,
    textarea::placeholder {
      color: #6b7280 !important;
    }

    label,
    .control-label {
      color: #9ca3af !important;
      font-weight: 500 !important;
    }

    /* Select2 dark theme */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #e5e7eb !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
      color: #6b7280 !important;
    }

    .select2-dropdown {
      background: #1e1e36 !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 10px !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
      background: rgba(255, 149, 0, 0.2) !important;
      color: #FF9500 !important;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
      background: rgba(255, 149, 0, 0.1) !important;
    }

    /* ======================================
       INPUT GROUP WITH ICONS - DARK THEME
       ====================================== */

    /* Input group container */
    .input-group {
      display: flex !important;
      align-items: stretch !important;
      width: 100% !important;
      position: relative !important;
    }

    /* Input group addon (icon container) - FIXED HEIGHT */
    .input-group-addon,
    .input-group-prepend,
    .input-group-append,
    .input-group .input-group-text,
    .input-group-btn {
      background: rgba(255, 149, 0, 0.15) !important;
      border: 1px solid rgba(255, 149, 0, 0.3) !important;
      border-right: none !important;
      color: #FF9500 !important;
      padding: 0 14px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      min-width: 44px !important;
      height: 38px !important;
      min-height: 38px !important;
      border-radius: 10px 0 0 10px !important;
      transition: all 0.2s ease !important;
      box-sizing: border-box !important;
    }

    /* Icons inside input group addon */
    .input-group-addon i,
    .input-group-addon .fa,
    .input-group-addon .fas,
    .input-group-addon .far,
    .input-group-addon .fab,
    .input-group-addon svg,
    .input-group-prepend i,
    .input-group-text i {
      color: #FF9500 !important;
      font-size: 0.9rem !important;
      width: 16px !important;
      height: 16px !important;
      line-height: 1 !important;
    }

    /* Input field when inside input group - MATCH HEIGHT */
    .input-group .form-control,
    .input-group input,
    .input-group select,
    .input-group textarea {
      border-radius: 0 10px 10px 0 !important;
      border-left: none !important;
      flex: 1 !important;
      height: 38px !important;
      min-height: 38px !important;
      padding: 6px 12px !important;
      box-sizing: border-box !important;
      line-height: 1.5 !important;
    }

    /* Select2 inside input group - match height */
    .input-group .select2-container,
    .input-group .select2-container--default {
      flex: 1 !important;
      height: 38px !important;
    }

    .input-group .select2-container--default .select2-selection--single {
      height: 38px !important;
      min-height: 38px !important;
      border-radius: 0 10px 10px 0 !important;
      border-left: none !important;
      display: flex !important;
      align-items: center !important;
      padding: 0 12px !important;
    }

    .input-group .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 36px !important;
      padding-left: 0 !important;
    }

    .input-group .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 36px !important;
      top: 0 !important;
    }

    /* Focus state - highlight both addon and input */
    .input-group .form-control:focus,
    .input-group input:focus {
      border-color: rgba(255, 149, 0, 0.5) !important;
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.1) !important;
    }

    .input-group:focus-within .input-group-addon,
    .input-group:focus-within .input-group-prepend {
      background: rgba(255, 149, 0, 0.25) !important;
      border-color: rgba(255, 149, 0, 0.5) !important;
    }

    .input-group:focus-within .input-group-addon i,
    .input-group:focus-within .input-group-addon svg {
      color: #FFB347 !important;
    }

    /* Right-side addon */
    .input-group-addon:last-child,
    .input-group-append {
      border-radius: 0 10px 10px 0 !important;
      border-left: none !important;
      border-right: 1px solid rgba(255, 149, 0, 0.3) !important;
    }

    .input-group .form-control:first-child,
    .input-group input:first-child {
      border-radius: 10px 0 0 10px !important;
      border-right: none !important;
      border-left: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    /* Has error state */
    .has-error .input-group-addon {
      background: rgba(239, 68, 68, 0.15) !important;
      border-color: rgba(239, 68, 68, 0.4) !important;
      color: #ef4444 !important;
    }

    .has-error .input-group-addon i,
    .has-error .input-group-addon svg {
      color: #ef4444 !important;
    }

    .has-error .form-control {
      border-color: rgba(239, 68, 68, 0.4) !important;
    }

    /* Has success state */
    .has-success .input-group-addon {
      background: rgba(16, 185, 129, 0.15) !important;
      border-color: rgba(16, 185, 129, 0.4) !important;
      color: #10b981 !important;
    }

    .has-success .input-group-addon i,
    .has-success .input-group-addon svg {
      color: #10b981 !important;
    }

    /* Select2 multi-select tags inside input group */
    .input-group .select2-container--default .select2-selection--multiple {
      min-height: 38px !important;
      border-radius: 0 10px 10px 0 !important;
      border-left: none !important;
      padding: 3px 8px !important;
      display: flex !important;
      align-items: center !important;
      flex-wrap: wrap !important;
      background: rgba(255, 255, 255, 0.05) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    .input-group .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-radius: 6px !important;
      padding: 3px 8px !important;
      margin: 2px !important;
      font-size: 0.8rem !important;
      font-weight: 500 !important;
      line-height: 1.4 !important;
    }

    .input-group .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
      color: #000000 !important;
      margin-right: 4px !important;
      font-weight: 700 !important;
    }

    .input-group .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
      color: #ef4444 !important;
    }

    /* Select2 multi-select - GLOBAL (not just in input-group) */
    .select2-container--default .select2-selection--multiple {
      background: rgba(255, 255, 255, 0.05) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 10px !important;
      min-height: 38px !important;
      padding: 4px 8px !important;
    }

    .select2-container--default .select2-selection--multiple:focus,
    .select2-container--default.select2-container--focus .select2-selection--multiple {
      border-color: rgba(255, 149, 0, 0.5) !important;
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.1) !important;
      outline: none !important;
    }

    /* Selected tags in multi-select */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-radius: 6px !important;
      padding: 4px 10px !important;
      margin: 3px 4px 3px 0 !important;
      font-size: 0.8rem !important;
      font-weight: 600 !important;
      line-height: 1.4 !important;
      display: inline-flex !important;
      align-items: center !important;
    }

    /* Remove button (x) on tags */
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
      color: #000000 !important;
      margin-right: 6px !important;
      font-weight: 700 !important;
      font-size: 1rem !important;
      cursor: pointer !important;
      border: none !important;
      background: transparent !important;
      padding: 0 !important;
      line-height: 1 !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
      color: #dc2626 !important;
      background: transparent !important;
    }

    /* Search input inside multi-select - REMOVE ALL BACKGROUNDS */
    .select2-container--default .select2-selection--multiple .select2-search--inline {
      margin-top: 0 !important;
      background: transparent !important;
      float: none !important;
      display: inline-flex !important;
      align-items: center !important;
    }

    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field,
    .select2-selection--multiple .select2-search__field,
    .select2-search__field {
      background: transparent !important;
      background-color: transparent !important;
      border: none !important;
      box-shadow: none !important;
      color: #e5e7eb !important;
      margin: 0 !important;
      padding: 4px 8px !important;
      height: 28px !important;
      min-height: 28px !important;
      line-height: 28px !important;
      outline: none !important;
    }

    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field::placeholder,
    .select2-search__field::placeholder {
      color: #6b7280 !important;
    }

    /* Remove any gray/white backgrounds from inner elements */
    .select2-selection--multiple *,
    .select2-selection--multiple ul,
    .select2-selection--multiple li {
      background: transparent !important;
      background-color: transparent !important;
    }

    /* Only the choice tags should have orange background */
    .select2-selection--multiple .select2-selection__choice {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
    }

    /* Clear all button */
    .select2-container--default .select2-selection--multiple .select2-selection__clear {
      color: #9ca3af !important;
      margin-right: 10px !important;
      font-size: 1.2rem !important;
      cursor: pointer !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__clear:hover {
      color: #ef4444 !important;
    }

    /* Fix the gray box issue - target the rendered area */
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
      display: flex !important;
      flex-wrap: wrap !important;
      align-items: center !important;
      padding: 0 !important;
      width: 100% !important;
      background: transparent !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
      list-style: none !important;
    }

    /* Radio buttons in forms */
    .radio-inline,
    .checkbox-inline {
      color: #e5e7eb !important;
      margin-right: 1rem !important;
    }

    input[type="radio"],
    input[type="checkbox"] {
      accent-color: #FF9500 !important;
      width: 18px !important;
      height: 18px !important;
      margin-right: 6px !important;
      cursor: pointer !important;
    }

    /* Radio/checkbox labels */
    .radio label,
    .checkbox label,
    .radio-inline label,
    .checkbox-inline label {
      color: #e5e7eb !important;
      font-weight: 400 !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 6px !important;
      cursor: pointer !important;
    }

    /* Form group spacing */
    .form-group {
      margin-bottom: 1.25rem !important;
    }

    .form-group label {
      margin-bottom: 0.5rem !important;
      display: block !important;
      color: #9ca3af !important;
      font-weight: 500 !important;
      font-size: 0.875rem !important;
    }

    /* Required field indicator */
    .form-group label.required::after,
    label[class*="required"]::after {
      content: "*" !important;
      color: #ef4444 !important;
      margin-left: 4px !important;
    }

    /* Help text under inputs */
    .help-block,
    .form-text,
    small.text-muted {
      color: #6b7280 !important;
      font-size: 0.75rem !important;
      margin-top: 0.35rem !important;
    }

    /* Select dropdown arrow - make it visible */
    select.form-control {
      appearance: none !important;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23FF9500' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") !important;
      background-repeat: no-repeat !important;
      background-position: right 12px center !important;
      padding-right: 36px !important;
    }

    /* ======================================
       TINYMCE EDITOR - DARK THEME
       ====================================== */

    /* TinyMCE container */
    .tox-tinymce,
    .tox.tox-tinymce {
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 10px !important;
      overflow: hidden !important;
    }

    /* TinyMCE toolbar/header */
    .tox .tox-menubar,
    .tox .tox-toolbar,
    .tox .tox-toolbar__primary,
    .tox .tox-toolbar__overflow,
    .tox-editor-header {
      background: #1e1e36 !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* Menu bar items */
    .tox .tox-mbtn,
    .tox .tox-mbtn__select-label {
      color: #9ca3af !important;
    }

    .tox .tox-mbtn:hover:not(:disabled):not(.tox-mbtn--active),
    .tox .tox-mbtn:focus:not(:disabled):not(.tox-mbtn--active) {
      background: rgba(255, 149, 0, 0.15) !important;
      color: #FF9500 !important;
    }

    .tox .tox-mbtn--active {
      background: rgba(255, 149, 0, 0.2) !important;
      color: #FF9500 !important;
    }

    /* Toolbar buttons */
    .tox .tox-tbtn,
    .tox .tox-split-button {
      color: #9ca3af !important;
    }

    .tox .tox-tbtn:hover,
    .tox .tox-split-button:hover,
    .tox .tox-tbtn:focus {
      background: rgba(255, 149, 0, 0.15) !important;
      color: #FF9500 !important;
    }

    .tox .tox-tbtn--enabled,
    .tox .tox-tbtn--enabled:hover {
      background: rgba(255, 149, 0, 0.25) !important;
      color: #FF9500 !important;
    }

    .tox .tox-tbtn svg {
      fill: currentColor !important;
    }

    /* Editor content area */
    .tox .tox-edit-area,
    .tox .tox-edit-area__iframe {
      background: #12121f !important;
    }

    /* Editor body (inside iframe - may need JS) */
    .tox .tox-edit-area iframe {
      background: #12121f !important;
    }

    /* Status bar */
    .tox .tox-statusbar {
      background: #1e1e36 !important;
      border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
      color: #6b7280 !important;
    }

    .tox .tox-statusbar__text-container {
      color: #6b7280 !important;
    }

    .tox .tox-statusbar a,
    .tox .tox-statusbar__path-item {
      color: #9ca3af !important;
    }

    /* Dropdown menus in TinyMCE */
    .tox .tox-menu,
    .tox .tox-collection,
    .tox .tox-collection__group {
      background: #1e1e36 !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    .tox .tox-collection__item {
      color: #e5e7eb !important;
    }

    .tox .tox-collection__item--active,
    .tox .tox-collection__item:hover {
      background: rgba(255, 149, 0, 0.15) !important;
      color: #FF9500 !important;
    }

    /* Dialogs */
    .tox .tox-dialog {
      background: #1e1e36 !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 12px !important;
    }

    .tox .tox-dialog__header {
      background: rgba(255, 255, 255, 0.03) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
      color: #ffffff !important;
    }

    .tox .tox-dialog__title {
      color: #ffffff !important;
    }

    .tox .tox-dialog__body-content {
      color: #e5e7eb !important;
    }

    .tox .tox-dialog__footer {
      background: rgba(255, 255, 255, 0.02) !important;
      border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* ======================================
       INFO/TOOLTIP ICONS - INLINE WITH LABELS
       ====================================== */

    /* Make form-group label inline with tooltip icon */
    .form-group > label {
      display: inline !important;
    }

    /* Info icon styling - must be inline next to label */
    .fa-info-circle,
    .fa-question-circle,
    i.text-info,
    i.hover-q,
    .info-icon,
    [data-toggle="popover"].fa-info-circle {
      color: #FF9500 !important;
      font-size: 0.9rem !important;
      cursor: help !important;
      transition: all 0.2s ease !important;
      margin-left: 6px !important;
      display: inline !important;
      vertical-align: baseline !important;
      position: relative !important;
      top: 0 !important;
    }

    .fa-info-circle:hover,
    .fa-question-circle:hover,
    i.text-info:hover,
    i.hover-q:hover {
      color: #FFB347 !important;
      transform: scale(1.15) !important;
    }

    /* Popover dark theme styling */
    .popover {
      background: linear-gradient(145deg, #1e1e36 0%, #16162a 100%) !important;
      border: 1px solid rgba(255, 149, 0, 0.2) !important;
      border-radius: 12px !important;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4) !important;
    }

    .popover-content,
    .popover-body {
      color: #e5e7eb !important;
      padding: 12px 16px !important;
      font-size: 0.85rem !important;
      line-height: 1.5 !important;
    }

    .popover-title,
    .popover-header {
      background: rgba(255, 149, 0, 0.1) !important;
      color: #FF9500 !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
      padding: 10px 16px !important;
      font-weight: 600 !important;
      border-radius: 12px 12px 0 0 !important;
    }

    /* Popover arrows */
    .popover.top > .arrow::after,
    .popover.bs-popover-top .arrow::after {
      border-top-color: #1e1e36 !important;
    }

    .popover.bottom > .arrow::after,
    .popover.bs-popover-bottom .arrow::after {
      border-bottom-color: #1e1e36 !important;
    }

    .popover.left > .arrow::after,
    .popover.bs-popover-start .arrow::after {
      border-left-color: #1e1e36 !important;
    }

    .popover.right > .arrow::after,
    .popover.bs-popover-end .arrow::after {
      border-right-color: #1e1e36 !important;
    }

    .popover > .arrow {
      border-color: transparent !important;
    }

    /* Bootstrap tooltip dark theme */
    .tooltip {
      z-index: 10000 !important;
    }

    .tooltip-inner {
      background: linear-gradient(145deg, #1e1e36 0%, #16162a 100%) !important;
      color: #e5e7eb !important;
      border: 1px solid rgba(255, 149, 0, 0.2) !important;
      border-radius: 8px !important;
      padding: 8px 12px !important;
      font-size: 0.8rem !important;
      max-width: 300px !important;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
    }

    .tooltip.top .tooltip-arrow,
    .bs-tooltip-top .arrow::before {
      border-top-color: #1e1e36 !important;
    }

    .tooltip.bottom .tooltip-arrow,
    .bs-tooltip-bottom .arrow::before {
      border-bottom-color: #1e1e36 !important;
    }

    .tooltip.left .tooltip-arrow,
    .bs-tooltip-start .arrow::before {
      border-left-color: #1e1e36 !important;
    }

    .tooltip.right .tooltip-arrow,
    .bs-tooltip-end .arrow::before {
      border-right-color: #1e1e36 !important;
    }

    /* ======================================
       ENHANCED CHECKBOX STYLING
       ====================================== */

    /* Custom checkbox container */
    .checkbox,
    .form-check {
      position: relative !important;
      padding-left: 0 !important;
    }

    /* Checkbox wrapper with label */
    .checkbox label,
    .form-check-label {
      display: inline-flex !important;
      align-items: center !important;
      gap: 10px !important;
      color: #e5e7eb !important;
      font-weight: 500 !important;
      cursor: pointer !important;
      padding: 8px 0 !important;
    }

    /* Custom styled checkbox */
    input[type="checkbox"] {
      appearance: none !important;
      -webkit-appearance: none !important;
      width: 22px !important;
      height: 22px !important;
      min-width: 22px !important;
      background: rgba(255, 255, 255, 0.05) !important;
      border: 2px solid rgba(255, 255, 255, 0.2) !important;
      border-radius: 6px !important;
      cursor: pointer !important;
      transition: all 0.2s ease !important;
      position: relative !important;
      flex-shrink: 0 !important;
    }

    input[type="checkbox"]:hover {
      border-color: rgba(255, 149, 0, 0.5) !important;
      background: rgba(255, 149, 0, 0.1) !important;
    }

    input[type="checkbox"]:checked {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      border-color: #FF9500 !important;
    }

    input[type="checkbox"]:checked::after {
      content: "✓" !important;
      position: absolute !important;
      top: 50% !important;
      left: 50% !important;
      transform: translate(-50%, -50%) !important;
      color: #000000 !important;
      font-size: 14px !important;
      font-weight: 700 !important;
      line-height: 1 !important;
    }

    input[type="checkbox"]:focus {
      outline: none !important;
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.2) !important;
    }

    /* iCheck plugin override if used */
    .icheckbox_square-blue,
    .iradio_square-blue,
    .icheckbox_flat-green,
    .iradio_flat-green {
      background: rgba(255, 255, 255, 0.05) !important;
      border: 2px solid rgba(255, 255, 255, 0.2) !important;
      border-radius: 6px !important;
    }

    .icheckbox_square-blue.checked,
    .icheckbox_flat-green.checked {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      border-color: #FF9500 !important;
    }

    /* ======================================
       ADD BUTTON (+ icon) STYLING
       ====================================== */

    /* Input group wrapper - proper flex alignment */
    .input-group {
      display: flex !important;
      align-items: stretch !important;
    }

    /* Input group button container */
    .input-group-btn {
      display: flex !important;
      align-items: center !important;
      margin-left: 0 !important;
    }

    /* Select2 inside input group should take remaining space */
    .input-group .select2-container {
      flex: 1 !important;
      min-width: 0 !important;
    }

    .input-group .select2-container .select2-selection {
      height: 42px !important;
      border-radius: 10px 0 0 10px !important;
    }

    /* Plus button next to select fields - btn-modal buttons */
    .input-group-btn .btn,
    .input-group-btn .btn.btn-modal,
    .input-group-btn .btn-flat,
    .input-group-btn button,
    .input-group-append .btn {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-radius: 0 10px 10px 0 !important;
      width: 46px !important;
      height: 42px !important;
      min-width: 46px !important;
      padding: 0 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      box-shadow: 0 3px 10px rgba(255, 149, 0, 0.35) !important;
      transition: all 0.2s ease !important;
      margin: 0 !important;
    }

    .input-group-btn .btn:hover,
    .input-group-btn .btn.btn-modal:hover,
    .input-group-append .btn:hover {
      background: linear-gradient(135deg, #FFB347 0%, #FF9500 100%) !important;
      box-shadow: 0 5px 15px rgba(255, 149, 0, 0.45) !important;
    }

    /* Plus icon inside the button */
    .input-group-btn .btn i,
    .input-group-btn .btn .fa,
    .input-group-btn .btn .fa-plus-circle,
    .input-group-append .btn i {
      color: #000000 !important;
      font-size: 1.2rem !important;
    }

    /* Remove text-primary color override for icons inside buttons */
    .input-group-btn .btn i.text-primary,
    .input-group-btn .btn .fa-plus-circle.text-primary {
      color: #000000 !important;
    }

    /* Regular flat buttons outside input-group */
    button.btn-flat:not(.input-group-btn .btn-flat),
    a.btn-flat:not(.input-group-btn .btn-flat) {
      background: rgba(255, 255, 255, 0.05) !important;
      color: #e5e7eb !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 8px !important;
    }

    button.btn-flat:not(.input-group-btn .btn-flat):hover,
    a.btn-flat:not(.input-group-btn .btn-flat):hover {
      background: rgba(255, 149, 0, 0.15) !important;
      border-color: rgba(255, 149, 0, 0.3) !important;
      color: #FF9500 !important;
    }

    /* ======================================
       FILE UPLOAD / IMAGE UPLOAD
       ====================================== */

    /* Style the file input directly */
    input[type="file"] {
      width: 100% !important;
      padding: 15px !important;
      background: linear-gradient(145deg, rgba(255, 149, 0, 0.1) 0%, rgba(255, 149, 0, 0.05) 100%) !important;
      border: 2px dashed rgba(255, 149, 0, 0.4) !important;
      border-radius: 12px !important;
      color: #9ca3af !important;
      cursor: pointer !important;
      transition: all 0.2s ease !important;
      min-height: 50px !important;
    }

    input[type="file"]:hover {
      border-color: #FF9500 !important;
      background: linear-gradient(145deg, rgba(255, 149, 0, 0.15) 0%, rgba(255, 149, 0, 0.08) 100%) !important;
    }

    input[type="file"]:focus {
      outline: none !important;
      border-color: #FF9500 !important;
      box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.2) !important;
    }

    /* Style the native file input button (Browse/Choose File) */
    input[type="file"]::file-selector-button {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-radius: 10px !important;
      padding: 12px 24px !important;
      font-weight: 600 !important;
      font-size: 0.9rem !important;
      cursor: pointer !important;
      margin-right: 15px !important;
      transition: all 0.2s ease !important;
      box-shadow: 0 3px 10px rgba(255, 149, 0, 0.3) !important;
    }

    input[type="file"]::file-selector-button:hover {
      background: linear-gradient(135deg, #FFB347 0%, #FF9500 100%) !important;
      box-shadow: 0 5px 15px rgba(255, 149, 0, 0.4) !important;
    }

    /* Webkit browsers (Chrome, Safari, Edge) */
    input[type="file"]::-webkit-file-upload-button {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-radius: 10px !important;
      padding: 12px 24px !important;
      font-weight: 600 !important;
      font-size: 0.9rem !important;
      cursor: pointer !important;
      margin-right: 15px !important;
      transition: all 0.2s ease !important;
      box-shadow: 0 3px 10px rgba(255, 149, 0, 0.3) !important;
    }

    input[type="file"]::-webkit-file-upload-button:hover {
      background: linear-gradient(135deg, #FFB347 0%, #FF9500 100%) !important;
      box-shadow: 0 5px 15px rgba(255, 149, 0, 0.4) !important;
    }

    /* ======================================
       BOOTSTRAP FILE INPUT (KRAJEE) PLUGIN
       ====================================== */

    /* Main file input wrapper */
    .file-input {
      background: transparent !important;
    }

    /* File caption (text input showing filename) */
    .file-caption {
      background: rgba(255, 255, 255, 0.05) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 10px 0 0 10px !important;
      height: 42px !important;
    }

    .file-caption .file-caption-name {
      color: #9ca3af !important;
      padding: 8px 12px !important;
    }

    .file-caption:focus {
      border-color: #FF9500 !important;
      box-shadow: 0 0 0 2px rgba(255, 149, 0, 0.15) !important;
    }

    /* Input group for file input */
    .input-group.file-caption-main {
      display: flex !important;
      align-items: stretch !important;
    }

    /* Button wrapper on the right */
    .file-input .input-group-btn,
    .file-input .input-group-append {
      display: flex !important;
      gap: 0 !important;
    }

    /* ================================================
       HIDE REMOVE AND CANCEL BUTTONS BY DEFAULT
       These should only show based on file input state
       ================================================ */

    /* Hide Remove button - only shown when file is selected (via JS) */
    .file-input .fileinput-remove,
    .file-input .btn-secondary,
    .file-input .btn[title*="Clear"],
    .file-input .kv-fileinput-remove,
    .file-input .fileinput-remove-button {
      display: none !important;
    }

    /* Hide Cancel button - only shown during upload (via JS) */
    .file-input .fileinput-cancel,
    .file-input .btn[title*="Cancel"],
    .file-input .kv-fileinput-cancel,
    .file-input .fileinput-cancel-button {
      display: none !important;
    }

    /* Hide Upload button if exists - for auto-upload scenarios */
    .file-input .fileinput-upload,
    .file-input .fileinput-upload-button {
      display: none !important;
    }

    /* Only show Browse button - ICON ONLY */
    .file-input .btn-file,
    .btn-file {
      display: inline-flex !important;
      height: 42px !important;
      width: 46px !important;
      min-width: 46px !important;
      padding: 0 !important;
      align-items: center !important;
      justify-content: center !important;
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-radius: 0 10px 10px 0 !important;
      box-shadow: 0 2px 8px rgba(255, 149, 0, 0.3) !important;
      font-size: 0 !important;
      line-height: 0 !important;
      transition: all 0.2s ease !important;
      overflow: hidden !important;
    }

    /* Hide "Browse" text completely */
    .file-input .btn-file span,
    .btn-file span,
    .file-input .btn-file .hidden-xs,
    .btn-file .hidden-xs {
      display: none !important;
      font-size: 0 !important;
    }

    .file-input .btn-file:hover,
    .btn-file:hover {
      background: linear-gradient(135deg, #FFB347 0%, #FF9500 100%) !important;
      box-shadow: 0 4px 12px rgba(255, 149, 0, 0.4) !important;
    }

    /* When there's no input-group, give browse full rounded corners */
    .file-input:not(:has(.file-caption)) .btn-file,
    .btn-file:only-child {
      border-radius: 10px !important;
    }

    /* Show only the folder icon */
    .file-input .btn-file i,
    .file-input .btn-file .fa,
    .btn-file i,
    .btn-file .fa {
      font-size: 1.25rem !important;
      color: #000000 !important;
      display: inline-block !important;
      line-height: 1 !important;
    }

    /* Ensure icon visibility */
    .file-input .btn .hidden-xs {
      display: inline !important;
    }

    /* File preview area */
    .file-preview {
      background: rgba(255, 255, 255, 0.03) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 10px !important;
      padding: 10px !important;
      margin-bottom: 10px !important;
    }

    .file-preview-frame {
      background: rgba(255, 255, 255, 0.05) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 8px !important;
    }

    .file-preview-image {
      border-radius: 6px !important;
    }

    /* File drop zone */
    .file-drop-zone {
      background: rgba(255, 149, 0, 0.05) !important;
      border: 2px dashed rgba(255, 149, 0, 0.3) !important;
      border-radius: 10px !important;
      min-height: 100px !important;
    }

    .file-drop-zone.clickable:hover {
      border-color: #FF9500 !important;
      background: rgba(255, 149, 0, 0.1) !important;
    }

    .file-drop-zone-title {
      color: #9ca3af !important;
      padding: 20px !important;
    }

    /* Dropzone styling */
    .file-upload,
    .image-upload,
    .dropzone {
      background: linear-gradient(145deg, rgba(255, 149, 0, 0.08) 0%, rgba(255, 149, 0, 0.03) 100%) !important;
      border: 2px dashed rgba(255, 149, 0, 0.4) !important;
      border-radius: 12px !important;
      padding: 30px !important;
      text-align: center !important;
      cursor: pointer !important;
      transition: all 0.2s ease !important;
      color: #9ca3af !important;
    }

    .file-upload:hover,
    .image-upload:hover,
    .dropzone:hover,
    .dropzone.dz-drag-hover {
      border-color: #FF9500 !important;
      background: rgba(255, 149, 0, 0.08) !important;
    }

    /* Upload icon in dropzone */
    .file-upload i,
    .image-upload i,
    .dropzone i,
    .dropzone .dz-message i {
      color: #FF9500 !important;
      font-size: 2.5rem !important;
      margin-bottom: 10px !important;
    }

    /* Dropzone message text */
    .dropzone .dz-message {
      color: #9ca3af !important;
      margin: 0 !important;
    }

    .dropzone .dz-message span {
      color: #9ca3af !important;
    }

    /* Help text under file upload */
    .form-group .help-block,
    .form-group small p {
      color: #6b7280 !important;
      font-size: 0.8rem !important;
      margin-top: 8px !important;
    }

    /* ======================================
       FORM SECTION DIVIDERS
       ====================================== */

    hr {
      border-color: rgba(255, 255, 255, 0.08) !important;
      margin: 1.5rem 0 !important;
    }

    /* Section headers in forms */
    .box-header,
    .panel-heading,
    .card-header,
    h4.modal-title,
    .form-section-title {
      color: #ffffff !important;
      font-weight: 600 !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
      padding-bottom: 0.75rem !important;
      margin-bottom: 1rem !important;
    }

    /* ======================================
       DARK BUTTONS
       ====================================== */

    .btn,
    button[type="submit"],
    button[type="button"] {
      border-radius: 10px !important;
      font-weight: 500 !important;
      transition: all 0.2s ease !important;
    }

    .btn-primary {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      border: none !important;
      color: #000 !important;
      box-shadow: 0 4px 15px rgba(255, 149, 0, 0.3) !important;
    }

    .btn-primary:hover {
      transform: translateY(-1px) !important;
      box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4) !important;
    }

    .btn-default,
    .btn-secondary {
      background: rgba(255, 255, 255, 0.05) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      color: #e5e7eb !important;
    }

    .btn-default:hover,
    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.1) !important;
      border-color: rgba(255, 255, 255, 0.2) !important;
    }

    .btn-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
      border: none !important;
      color: #fff !important;
    }

    .btn-danger {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
      border: none !important;
      color: #fff !important;
    }

    .btn-warning {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
      border: none !important;
      color: #000 !important;
    }

    .btn-info {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
      border: none !important;
      color: #fff !important;
    }

    /* ======================================
       DARK MODALS
       ====================================== */

    .modal-content {
      background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 16px !important;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
    }

    .modal-header {
      background: rgba(255, 255, 255, 0.03) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
      border-radius: 16px 16px 0 0 !important;
    }

    .modal-title {
      color: #ffffff !important;
      font-weight: 600 !important;
    }

    .modal-body {
      color: #e5e7eb !important;
    }

    .modal-footer {
      background: rgba(255, 255, 255, 0.02) !important;
      border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
      border-radius: 0 0 16px 16px !important;
    }

    .close {
      color: #9ca3af !important;
      opacity: 1 !important;
    }

    .close:hover {
      color: #FF9500 !important;
    }

    /* ======================================
       DARK ALERTS
       ====================================== */

    .alert {
      border-radius: 12px !important;
      border: none !important;
    }

    .alert-success {
      background: rgba(16, 185, 129, 0.15) !important;
      color: #10b981 !important;
      border-left: 4px solid #10b981 !important;
    }

    .alert-danger {
      background: rgba(239, 68, 68, 0.15) !important;
      color: #ef4444 !important;
      border-left: 4px solid #ef4444 !important;
    }

    .alert-warning {
      background: rgba(245, 158, 11, 0.15) !important;
      color: #f59e0b !important;
      border-left: 4px solid #f59e0b !important;
    }

    .alert-info {
      background: rgba(59, 130, 246, 0.15) !important;
      color: #3b82f6 !important;
      border-left: 4px solid #3b82f6 !important;
    }

    /* ======================================
       DARK PANELS & BOXES
       ====================================== */

    .panel,
    .box-default,
    .card {
      background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
      border: 1px solid rgba(255, 255, 255, 0.06) !important;
      border-radius: 16px !important;
    }

    .panel-heading,
    .box-header,
    .card-header {
      background: rgba(255, 255, 255, 0.03) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
      color: #ffffff !important;
    }

    .panel-body,
    .card-body {
      color: #e5e7eb !important;
    }

    /* ======================================
       DARK TABS & NAV - ENHANCED
       ====================================== */

    .nav-tabs {
      border-bottom: 2px solid rgba(255, 255, 255, 0.08) !important;
      margin-bottom: 1.5rem !important;
      background: transparent !important;
      display: flex !important;
      gap: 0.5rem !important;
    }

    .nav-tabs > li {
      margin-bottom: -2px !important;
    }

    .nav-tabs > li > a {
      color: #9ca3af !important;
      border: none !important;
      border-radius: 10px 10px 0 0 !important;
      padding: 12px 20px !important;
      font-weight: 600 !important;
      font-size: 0.9rem !important;
      background: rgba(255, 255, 255, 0.03) !important;
      transition: all 0.2s ease !important;
      display: flex !important;
      align-items: center !important;
      gap: 8px !important;
    }

    .nav-tabs > li > a i,
    .nav-tabs > li > a svg {
      font-size: 1rem !important;
      color: inherit !important;
    }

    .nav-tabs > li > a:hover {
      background: rgba(255, 149, 0, 0.15) !important;
      color: #FF9500 !important;
      border: none !important;
    }

    .nav-tabs > li.active > a,
    .nav-tabs > li.active > a:hover,
    .nav-tabs > li.active > a:focus {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-bottom: none !important;
      box-shadow: 0 4px 15px rgba(255, 149, 0, 0.3) !important;
    }

    .nav-tabs > li.active > a i,
    .nav-tabs > li.active > a svg {
      color: #000000 !important;
    }

    /* Tab content area */
    .tab-content {
      background: transparent !important;
      padding-top: 1rem !important;
    }

    .tab-pane {
      animation: fadeIn 0.3s ease !important;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* ======================================
       PAGE HEADER BUTTONS
       ====================================== */

    /* Add button - Primary orange */
    .btn-block.btn-xs,
    a[href*="create"].btn,
    button[class*="add"],
    .btn-modal,
    a.btn.btn-primary {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-radius: 10px !important;
      padding: 10px 20px !important;
      font-weight: 600 !important;
      font-size: 0.875rem !important;
      box-shadow: 0 4px 15px rgba(255, 149, 0, 0.3) !important;
      transition: all 0.2s ease !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 8px !important;
    }

    .btn-block.btn-xs:hover,
    a[href*="create"].btn:hover,
    a.btn.btn-primary:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4) !important;
    }

    /* Download/Export buttons */
    a[href*="download"].btn,
    .btn-success:not(.btn-primary),
    button[class*="export"],
    button[class*="download"] {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
      color: #ffffff !important;
      border: none !important;
      border-radius: 10px !important;
      padding: 10px 20px !important;
      font-weight: 600 !important;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3) !important;
    }

    a[href*="download"].btn:hover,
    .btn-success:not(.btn-primary):hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4) !important;
    }

    /* Secondary/outline buttons */
    .btn-default,
    .btn-outline,
    button[class*="column"],
    button[class*="print"],
    button[class*="visibility"] {
      background: rgba(255, 255, 255, 0.06) !important;
      color: #e5e7eb !important;
      border: 1px solid rgba(255, 255, 255, 0.15) !important;
      border-radius: 10px !important;
      padding: 10px 16px !important;
      font-weight: 500 !important;
      transition: all 0.2s ease !important;
    }

    .btn-default:hover,
    .btn-outline:hover {
      background: rgba(255, 149, 0, 0.1) !important;
      border-color: rgba(255, 149, 0, 0.3) !important;
      color: #FF9500 !important;
    }

    /* Button groups */
    .btn-group {
      display: inline-flex !important;
      gap: 4px !important;
    }

    .btn-group .btn {
      border-radius: 8px !important;
    }

    /* ======================================
       FILTERS SECTION
       ====================================== */

    .filters-row,
    [class*="filter"],
    .box-header.with-border {
      background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
      border: 1px solid rgba(255, 255, 255, 0.08) !important;
      border-radius: 12px !important;
      padding: 1rem !important;
      margin-bottom: 1rem !important;
    }

    .filters-row label,
    [class*="filter"] label {
      color: #9ca3af !important;
      font-weight: 500 !important;
      font-size: 0.8125rem !important;
    }

    /* ======================================
       CONTENT SECTION HEADER
       ====================================== */

    .content-header,
    .page-header,
    section.content-header {
      background: transparent !important;
      padding: 1rem 1.5rem !important;
      margin-bottom: 1rem !important;
    }

    .content-header h1,
    .page-header h1 {
      color: #ffffff !important;
      font-weight: 700 !important;
      font-size: 1.5rem !important;
      padding-left: 0 !important;
    }

    /* Main content section padding */
    section.content,
    .content-wrapper > .content {
      padding-left: 1.5rem !important;
      padding-right: 1.5rem !important;
    }

    .content-header .breadcrumb,
    .page-header .breadcrumb {
      background: transparent !important;
      margin: 0 !important;
      padding: 0 !important;
    }

    /* ======================================
       MOBILE RESPONSIVE - BUTTONS & TABS
       ====================================== */

    @media (max-width: 768px) {
      .nav-tabs {
        flex-wrap: wrap !important;
        gap: 0.25rem !important;
      }

      .nav-tabs > li > a {
        padding: 10px 14px !important;
        font-size: 0.8rem !important;
      }

      .btn-block.btn-xs,
      a[href*="create"].btn,
      a.btn.btn-primary,
      .btn-default {
        padding: 8px 14px !important;
        font-size: 0.8rem !important;
      }

      .btn-group {
        flex-wrap: wrap !important;
      }
    }

    @media (max-width: 480px) {
      .nav-tabs > li {
        flex: 1 1 auto !important;
      }

      .nav-tabs > li > a {
        padding: 8px 10px !important;
        font-size: 0.75rem !important;
        justify-content: center !important;
        text-align: center !important;
      }

      .btn-block.btn-xs,
      a[href*="create"].btn,
      a.btn.btn-primary {
        padding: 8px 12px !important;
        font-size: 0.75rem !important;
        width: 100% !important;
        justify-content: center !important;
      }
    }

    /* ======================================
       DARK WELCOME MESSAGE
       ====================================== */

    h1[class*="tw-text-"],
    .tw-text-4xl.tw-font-bold {
      color: #ffffff !important;
      -webkit-text-fill-color: #ffffff !important;
      background: none !important;
    }

    /* ======================================
       DARK FILTER BUTTON
       ====================================== */

    button[class*="filter"],
    #dashboard_date_filter,
    .tw-inline-flex[class*="tw-border"] {
      background: rgba(255, 255, 255, 0.05) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 10px !important;
      color: #e5e7eb !important;
      box-shadow: none !important;
      transition: all 0.2s ease !important;
    }

    button[class*="filter"]:hover,
    #dashboard_date_filter:hover {
      background: rgba(255, 149, 0, 0.1) !important;
      border-color: rgba(255, 149, 0, 0.3) !important;
      color: #FF9500 !important;
    }

    /* ======================================
       DARK DROPDOWNS
       ====================================== */

    .dropdown-menu {
      background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 12px !important;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3) !important;
    }

    .dropdown-menu > li > a {
      color: #9ca3af !important;
    }

    .dropdown-menu > li > a:hover {
      background: rgba(255, 149, 0, 0.1) !important;
      color: #FF9500 !important;
    }

    /* ======================================
       DARK BADGES & LABELS
       ====================================== */

    .badge,
    .label {
      border-radius: 6px !important;
      font-weight: 600 !important;
    }

    .badge-primary,
    .label-primary {
      background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
      color: #000 !important;
    }

    .badge-success,
    .label-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    }

    .badge-danger,
    .label-danger {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    }

    .badge-warning,
    .label-warning {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
      color: #000 !important;
    }

    /* ======================================
       DARK BREADCRUMBS
       ====================================== */

    .breadcrumb {
      background: transparent !important;
    }

    .breadcrumb > li {
      color: #9ca3af !important;
    }

    .breadcrumb > li > a {
      color: #9ca3af !important;
    }

    .breadcrumb > li > a:hover {
      color: #FF9500 !important;
    }

    .breadcrumb > .active {
      color: #FF9500 !important;
    }

    /* ======================================
       DARK SCROLLBARS
       ====================================== */

    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    ::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.02);
    }

    ::-webkit-scrollbar-thumb {
      background: rgba(255, 149, 0, 0.2);
      border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 149, 0, 0.4);
    }

    /* ======================================
       DARK TEXT COLORS
       ====================================== */

    .text-muted {
      color: #6b7280 !important;
    }

    .tw-text-gray-900 {
      color: #ffffff !important;
    }

    .tw-text-gray-700 {
      color: #e5e7eb !important;
    }

    .tw-text-gray-600 {
      color: #d1d5db !important;
    }

    p, span, div {
      color: inherit;
    }

    /* ======================================
       RESPONSIVE IMPROVEMENTS
       ====================================== */

    @media (max-width: 1024px) {
      .tw-bg-white.tw-shadow-sm.tw-rounded-xl {
        border-radius: 12px !important;
      }
    }

    /* ======================================
       ANIMATION IMPROVEMENTS
       ====================================== */

    /* Smooth transitions for all interactive elements */
    aside ul li a,
    .tw-bg-white.tw-shadow-sm.tw-rounded-xl,
    button,
    a {
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* Pulse animation for online indicator */
    @keyframes pulse-green {
      0%, 100% {
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
      }
      50% {
        box-shadow: 0 0 0 6px rgba(34, 197, 94, 0);
      }
    }

    #online_indicator {
      animation: pulse-green 2s infinite !important;
      background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
    }

    /* ======================================
       CONTENT WRAPPER FIX
       ====================================== */

    .content-wrapper,
    .main-content,
    section.content {
      background: transparent !important;
    }

    /* ======================================
       SPECIAL BADGES & STATUS INDICATORS
       ====================================== */

    /* Not for selling badge */
    .badge-not-for-sale,
    span[class*="not-for"],
    .label-not-selling,
    span:contains("Not for selling") {
      background: rgba(239, 68, 68, 0.15) !important;
      color: #f87171 !important;
      border: 1px solid rgba(239, 68, 68, 0.3) !important;
      border-radius: 6px !important;
      padding: 4px 10px !important;
      font-size: 0.7rem !important;
      font-weight: 600 !important;
    }

    /* Stock status badges */
    .badge-in-stock,
    .label-in-stock {
      background: rgba(16, 185, 129, 0.15) !important;
      color: #34d399 !important;
      border: 1px solid rgba(16, 185, 129, 0.3) !important;
    }

    .badge-low-stock,
    .label-low-stock {
      background: rgba(245, 158, 11, 0.15) !important;
      color: #fbbf24 !important;
      border: 1px solid rgba(245, 158, 11, 0.3) !important;
    }

    .badge-out-of-stock,
    .label-out-of-stock {
      background: rgba(239, 68, 68, 0.15) !important;
      color: #f87171 !important;
      border: 1px solid rgba(239, 68, 68, 0.3) !important;
    }

    /* ======================================
       TABLE BOTTOM ACTION BUTTONS
       ====================================== */

    /* Delete Selected - Red */
    .btn-danger,
    button[class*="delete"],
    a[class*="delete"] {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
      color: #ffffff !important;
      border: none !important;
      border-radius: 8px !important;
      padding: 8px 16px !important;
      font-weight: 600 !important;
      font-size: 0.8rem !important;
      transition: all 0.2s ease !important;
    }

    .btn-danger:hover,
    button[class*="delete"]:hover {
      transform: translateY(-1px) !important;
      box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4) !important;
    }

    /* Add to location - Blue/Info */
    .btn-info,
    button[class*="location"] {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
      color: #ffffff !important;
      border: none !important;
      border-radius: 8px !important;
      padding: 8px 16px !important;
      font-weight: 600 !important;
    }

    .btn-info:hover {
      transform: translateY(-1px) !important;
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4) !important;
    }

    /* Deactivate Selected - Warning/Yellow */
    .btn-warning,
    button[class*="deactivate"] {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
      color: #000000 !important;
      border: none !important;
      border-radius: 8px !important;
      padding: 8px 16px !important;
      font-weight: 600 !important;
    }

    .btn-warning:hover {
      transform: translateY(-1px) !important;
      box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4) !important;
    }

    /* WooCommerce Sync - Purple */
    button[class*="sync"],
    button[class*="woo"],
    .btn-woocommerce {
      background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important;
      color: #ffffff !important;
      border: none !important;
      border-radius: 8px !important;
      padding: 8px 16px !important;
      font-weight: 600 !important;
    }

    button[class*="sync"]:hover,
    button[class*="woo"]:hover {
      transform: translateY(-1px) !important;
      box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4) !important;
    }

    /* Table bottom action bar */
    .table-actions,
    .bulk-actions,
    .dataTables_wrapper + div,
    div[class*="action-buttons"] {
      display: flex !important;
      flex-wrap: wrap !important;
      gap: 8px !important;
      padding: 1rem !important;
      margin-top: 1rem !important;
      background: rgba(0, 0, 0, 0.2) !important;
      border-radius: 12px !important;
      border: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    /* ======================================
       CURRENCY & PRICE FORMATTING
       ====================================== */

    /* Naira/Currency symbol */
    td[class*="price"],
    td[class*="amount"],
    .currency-value,
    span[class*="price"] {
      font-family: 'SF Mono', 'Monaco', 'Consolas', monospace !important;
      color: #10b981 !important;
      font-weight: 600 !important;
    }

    /* Product SKU styling */
    td[class*="sku"],
    .sku-value {
      font-family: 'SF Mono', 'Monaco', 'Consolas', monospace !important;
      color: #9ca3af !important;
      font-size: 0.8rem !important;
    }

    /* ======================================
       RESPONSIVE BOTTOM BUTTONS
       ====================================== */

    @media (max-width: 768px) {
      .table-actions,
      .bulk-actions {
        justify-content: center !important;
      }

      .btn-danger,
      .btn-info,
      .btn-warning,
      button[class*="sync"] {
        padding: 6px 12px !important;
        font-size: 0.75rem !important;
        flex: 1 1 auto !important;
        min-width: 120px !important;
        text-align: center !important;
        justify-content: center !important;
      }
    }

    @media (max-width: 480px) {
      .table-actions,
      .bulk-actions {
        flex-direction: column !important;
      }

      .btn-danger,
      .btn-info,
      .btn-warning,
      button[class*="sync"] {
        width: 100% !important;
      }
    }

    /* ======================================
       PRINT STYLES
       ====================================== */

    @media print {
      body,
      .dark-theme-body,
      .main-content-area {
        background: #fff !important;
        color: #000 !important;
      }

      .tw-bg-white.tw-shadow-sm.tw-rounded-xl,
      .box,
      .panel {
        background: #fff !important;
        color: #000 !important;
        border-color: #ddd !important;
      }

      table tbody td,
      table thead th {
        color: #000 !important;
        background: #fff !important;
      }
    }

    /* ======================================
       SIDEBAR MENU ORANGE OVERRIDE
       Custom Menu Presenter with Tailwind classes
       ====================================== */

    /* Container - remove light theme styles */
    #side-bar,
    .modern-sidebar #side-bar,
    aside #side-bar {
        border-right: none !important;
        background: transparent !important;
        border-color: transparent !important;
    }

    /* All menu links in sidebar - dark theme base */
    #side-bar a,
    .modern-sidebar #side-bar a,
    aside.modern-sidebar #side-bar a {
        color: #9ca3af !important;
        background: transparent !important;
        transition: all 0.2s ease !important;
    }

    /* Menu items hover - Orange background */
    #side-bar a:hover,
    .modern-sidebar #side-bar a:hover,
    aside.modern-sidebar #side-bar a:hover {
        background: #FF9500 !important;
        background-color: #FF9500 !important;
        color: #000000 !important;
    }

    #side-bar a:hover *,
    .modern-sidebar #side-bar a:hover * {
        color: #000000 !important;
    }

    /* Dropdown parent when expanded (has active child) - Orange background */
    #side-bar .tw-pb-1 > a.drop_down,
    #side-bar .tw-rounded-md > a.drop_down,
    #side-bar .tw-bg-gray-200 > a.drop_down,
    #side-bar div.tw-pb-1.tw-rounded-md > a,
    #side-bar div.tw-pb-1.tw-rounded-md.tw-bg-gray-200 > a,
    #side-bar div[class*="tw-pb-1"][class*="tw-rounded-md"] > a.drop_down,
    .modern-sidebar #side-bar .tw-pb-1 > a.drop_down,
    .modern-sidebar #side-bar .tw-rounded-md > a.drop_down,
    .modern-sidebar #side-bar .tw-bg-gray-200 > a.drop_down,
    .modern-sidebar #side-bar div.tw-pb-1.tw-rounded-md > a,
    aside #side-bar .tw-pb-1 > a.drop_down,
    aside #side-bar .tw-rounded-md > a.drop_down,
    aside #side-bar div.tw-pb-1.tw-rounded-md > a {
        background: #FF9500 !important;
        background-color: #FF9500 !important;
        color: #000000 !important;
    }

    #side-bar .tw-pb-1 > a.drop_down *,
    #side-bar .tw-rounded-md > a.drop_down *,
    #side-bar .tw-bg-gray-200 > a.drop_down *,
    #side-bar div.tw-pb-1.tw-rounded-md > a *,
    .modern-sidebar #side-bar .tw-pb-1 > a.drop_down *,
    .modern-sidebar #side-bar .tw-rounded-md > a.drop_down * {
        color: #000000 !important;
    }

    /* Remove white/gray background from wrapper divs */
    #side-bar > div.tw-pb-1,
    #side-bar > div.tw-rounded-md,
    #side-bar > div.tw-bg-gray-200,
    #side-bar > div[class*="tw-bg-gray"],
    .modern-sidebar #side-bar > div.tw-pb-1,
    .modern-sidebar #side-bar > div.tw-rounded-md,
    .modern-sidebar #side-bar > div.tw-bg-gray-200 {
        background: transparent !important;
        background-color: transparent !important;
    }

    /* Child menu container - dark background */
    #side-bar .chiled,
    #side-bar div.tw-pl-11,
    #side-bar div.tw-relative.tw-mt-2.tw-mb-4.tw-pl-11,
    .modern-sidebar #side-bar .chiled,
    .modern-sidebar #side-bar div.tw-pl-11 {
        background: rgba(0, 0, 0, 0.25) !important;
        background-color: rgba(0, 0, 0, 0.25) !important;
        border-radius: 0 0 8px 8px !important;
    }

    /* Vertical line in child menu - Orange tint */
    #side-bar .chiled .tw-bg-gray-200,
    #side-bar .chiled div.tw-w-px,
    #side-bar div.tw-pl-11 .tw-bg-gray-200,
    .modern-sidebar #side-bar .chiled .tw-bg-gray-200,
    .modern-sidebar #side-bar .chiled div.tw-w-px {
        background: rgba(255, 149, 0, 0.4) !important;
        background-color: rgba(255, 149, 0, 0.4) !important;
    }

    /* Child menu items - gray text */
    #side-bar .chiled a,
    #side-bar div.tw-pl-11 a,
    .modern-sidebar #side-bar .chiled a {
        color: #9ca3af !important;
    }

    /* Child menu items hover - Orange */
    #side-bar .chiled a:hover,
    #side-bar div.tw-pl-11 a:hover,
    .modern-sidebar #side-bar .chiled a:hover {
        background: #FF9500 !important;
        background-color: #FF9500 !important;
        color: #000000 !important;
    }

    /* Active child item - Orange text */
    #side-bar .chiled a.tw-text-primary-700,
    #side-bar .chiled a[class*="tw-text-primary"],
    #side-bar div.tw-pl-11 a.tw-text-primary-700,
    .modern-sidebar #side-bar .chiled a.tw-text-primary-700 {
        color: #FF9500 !important;
        font-weight: 600 !important;
    }

    /* Active single menu item (like Home) - Orange gradient */
    #side-bar > a.tw-bg-gray-200,
    #side-bar > a[class*="tw-bg-gray-200"],
    .modern-sidebar #side-bar > a.tw-bg-gray-200 {
        background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
        color: #000000 !important;
    }

    #side-bar > a.tw-bg-gray-200 *,
    .modern-sidebar #side-bar > a.tw-bg-gray-200 * {
        color: #000000 !important;
    }

    /* Override any gray hover states from Tailwind */
    #side-bar a[class*="hover:tw-bg-gray"]:hover,
    #side-bar a[class*="focus:tw-bg-gray"]:focus,
    .modern-sidebar #side-bar a[class*="hover:tw-bg-gray"]:hover {
        background: #FF9500 !important;
        background-color: #FF9500 !important;
        color: #000000 !important;
    }

    /* ======================================
       NAV-TABS-CUSTOM - DARK THEME
       ====================================== */

    .nav-tabs-custom {
        background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.3) !important;
        overflow: hidden;
        margin-bottom: 1.5rem !important;
    }

    .nav-tabs-custom > .nav-tabs {
        background: rgba(0, 0, 0, 0.2) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 0.75rem 1rem !important;
        margin: 0 !important;
        display: flex !important;
        gap: 0.5rem !important;
    }

    .nav-tabs-custom > .nav-tabs > li {
        margin: 0 !important;
    }

    .nav-tabs-custom > .nav-tabs > li > a {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 10px !important;
        color: #9ca3af !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }

    .nav-tabs-custom > .nav-tabs > li > a:hover {
        background: rgba(255, 149, 0, 0.15) !important;
        border-color: rgba(255, 149, 0, 0.3) !important;
        color: #FF9500 !important;
    }

    .nav-tabs-custom > .nav-tabs > li.active > a,
    .nav-tabs-custom > .nav-tabs > li.active > a:hover,
    .nav-tabs-custom > .nav-tabs > li.active > a:focus {
        background: linear-gradient(135deg, #FF9500 0%, #E68600 100%) !important;
        border-color: transparent !important;
        color: #000000 !important;
        box-shadow: 0 4px 15px rgba(255, 149, 0, 0.3) !important;
    }

    .nav-tabs-custom > .nav-tabs > li.active > a i,
    .nav-tabs-custom > .nav-tabs > li.active > a svg {
        color: #000000 !important;
    }

    .nav-tabs-custom > .nav-tabs > li > a i,
    .nav-tabs-custom > .nav-tabs > li > a svg {
        font-size: 1rem !important;
    }

    .nav-tabs-custom > .tab-content {
        padding: 1.25rem !important;
        background: transparent !important;
    }

    /* ======================================
       ENHANCED DATATABLE BUTTONS (dt-buttons)
       ====================================== */

    .dt-buttons {
        display: inline-flex !important;
        flex-wrap: wrap !important;
        gap: 8px !important;
        margin-bottom: 1rem !important;
    }

    .dt-buttons .dt-button,
    .dt-buttons button.dt-button,
    .dt-buttons a.dt-button,
    .dt-buttons .btn.buttons-csv,
    .dt-buttons .btn.buttons-excel,
    .dt-buttons .btn.buttons-pdf,
    .dt-buttons .btn.buttons-print,
    .dt-buttons .btn.buttons-copy,
    .dt-buttons .btn.buttons-colvis {
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #e5e7eb !important;
        border-radius: 10px !important;
        padding: 10px 18px !important;
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        margin: 0 !important;
    }

    .dt-buttons .dt-button:hover,
    .dt-buttons button.dt-button:hover,
    .dt-buttons a.dt-button:hover,
    .dt-buttons .btn.buttons-csv:hover,
    .dt-buttons .btn.buttons-excel:hover,
    .dt-buttons .btn.buttons-pdf:hover,
    .dt-buttons .btn.buttons-print:hover,
    .dt-buttons .btn.buttons-copy:hover,
    .dt-buttons .btn.buttons-colvis:hover {
        background: rgba(255, 149, 0, 0.15) !important;
        border-color: rgba(255, 149, 0, 0.4) !important;
        color: #FF9500 !important;
        transform: translateY(-1px) !important;
    }

    /* Column visibility dropdown */
    .dt-button-collection {
        background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.5) !important;
        padding: 8px !important;
    }

    .dt-button-collection .dt-button,
    .dt-button-collection button.dt-button {
        background: transparent !important;
        border: none !important;
        color: #e5e7eb !important;
        border-radius: 8px !important;
        padding: 10px 16px !important;
        width: 100% !important;
        text-align: left !important;
        margin: 2px 0 !important;
    }

    .dt-button-collection .dt-button:hover,
    .dt-button-collection button.dt-button:hover {
        background: rgba(255, 149, 0, 0.15) !important;
        color: #FF9500 !important;
    }

    .dt-button-collection .dt-button.active,
    .dt-button-collection button.dt-button.active {
        background: rgba(255, 149, 0, 0.2) !important;
        color: #FF9500 !important;
    }

    /* ======================================
       DATATABLE WRAPPER IMPROVEMENTS
       ====================================== */

    .dataTables_wrapper {
        background: linear-gradient(145deg, #1e1e36 0%, #1a1a2e 100%) !important;
        border-radius: 16px !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 1.25rem !important;
    }

    /* DataTable header row (length, buttons, filter) */
    .dataTables_wrapper .row:first-child {
        margin-bottom: 1rem !important;
        padding-bottom: 1rem !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    /* Table styling inside nav-tabs-custom */
    .nav-tabs-custom .table,
    .nav-tabs-custom table.dataTable {
        background: transparent !important;
    }

    .nav-tabs-custom .dataTables_wrapper {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
    }

    /* ======================================
       TABLE HEADER DARK THEME FIX
       ====================================== */

    table.dataTable thead th,
    .table thead th,
    table thead th {
        background: rgba(255, 149, 0, 0.08) !important;
        color: #FF9500 !important;
        border: none !important;
        border-bottom: 2px solid rgba(255, 149, 0, 0.25) !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        font-size: 0.7rem !important;
        letter-spacing: 0.08em !important;
        padding: 14px 12px !important;
        white-space: nowrap !important;
    }

    table.dataTable thead th:first-child,
    .table thead th:first-child {
        border-radius: 8px 0 0 0 !important;
    }

    table.dataTable thead th:last-child,
    .table thead th:last-child {
        border-radius: 0 8px 0 0 !important;
    }

    /* Sorting icons */
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after {
        opacity: 0.5 !important;
    }

    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after {
        opacity: 1 !important;
        color: #FF9500 !important;
    }

    /* Table body */
    table.dataTable tbody td,
    .table tbody td {
        background: transparent !important;
        color: #e5e7eb !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        padding: 12px !important;
        font-size: 0.875rem !important;
        vertical-align: middle !important;
    }

    table.dataTable tbody tr:hover td,
    .table tbody tr:hover td {
        background: rgba(255, 149, 0, 0.08) !important;
    }

    /* Table row alternating colors */
    table.dataTable tbody tr:nth-child(odd) td,
    .table-striped tbody tr:nth-child(odd) td {
        background: rgba(255, 255, 255, 0.02) !important;
    }

    table.dataTable tbody tr:nth-child(odd):hover td {
        background: rgba(255, 149, 0, 0.08) !important;
    }

    /* Action buttons in table */
    table.dataTable tbody td .btn-xs,
    table.dataTable tbody td .btn-sm,
    .table tbody td .btn-xs,
    .table tbody td .btn-sm {
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #e5e7eb !important;
        border-radius: 6px !important;
        padding: 4px 10px !important;
        font-size: 0.75rem !important;
        margin: 2px !important;
        transition: all 0.2s ease !important;
    }

    table.dataTable tbody td .btn-xs:hover,
    table.dataTable tbody td .btn-sm:hover,
    .table tbody td .btn-xs:hover,
    .table tbody td .btn-sm:hover {
        background: rgba(255, 149, 0, 0.15) !important;
        border-color: rgba(255, 149, 0, 0.3) !important;
        color: #FF9500 !important;
    }

    /* ======================================
       BOX & CARD DARK THEME
       ====================================== */

    .box-header {
        background: rgba(0, 0, 0, 0.2) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        padding: 1rem !important;
        border-radius: 16px 16px 0 0 !important;
    }

    .box-header .box-title {
        color: #ffffff !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
    }

    .box-body {
        padding: 1.25rem !important;
        background: transparent !important;
    }

    /* CRM Module specific overrides */
    section.content .box,
    section.content .box-body,
    section.content .tw-bg-gradient-to-br {
        background: transparent !important;
    }

    /* Ensure dark backgrounds are maintained */
    .tw-from-\[\#1a1a2e\],
    .tw-to-\[\#252540\],
    [class*="tw-from-[#1a1a2e]"],
    [class*="tw-to-[#252540]"] {
        background: linear-gradient(145deg, #1a1a2e 0%, #252540 100%) !important;
    }

    /* Empty state containers */
    .empty-state-container,
    [class*="empty-state"] {
        background: transparent !important;
    }

    .box-footer {
        background: rgba(0, 0, 0, 0.1) !important;
        border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        padding: 1rem !important;
        border-radius: 0 0 16px 16px !important;
    }

    /* ======================================
       MOBILE RESPONSIVE - NAV-TABS-CUSTOM
       ====================================== */

    @media (max-width: 768px) {
        .nav-tabs-custom > .nav-tabs {
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
        }

        .nav-tabs-custom > .nav-tabs > li > a {
            padding: 8px 14px !important;
            font-size: 0.75rem !important;
        }

        .dt-buttons {
            gap: 6px !important;
        }

        .dt-buttons .dt-button,
        .dt-buttons button.dt-button,
        .dt-buttons .btn.buttons-csv,
        .dt-buttons .btn.buttons-excel,
        .dt-buttons .btn.buttons-print,
        .dt-buttons .btn.buttons-colvis {
            padding: 8px 12px !important;
            font-size: 0.75rem !important;
        }
    }

    @media (max-width: 480px) {
        .nav-tabs-custom > .nav-tabs > li {
            flex: 1 1 auto !important;
        }

        .nav-tabs-custom > .nav-tabs > li > a {
            padding: 8px 10px !important;
            font-size: 0.7rem !important;
            justify-content: center !important;
            text-align: center !important;
        }

        .nav-tabs-custom > .tab-content {
            padding: 0.75rem !important;
        }
    }
  </style>