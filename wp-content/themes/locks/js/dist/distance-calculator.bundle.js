/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./wp-content/themes/locks/js/distance-calculator.js":
/*!***********************************************************!*\
  !*** ./wp-content/themes/locks/js/distance-calculator.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\nObject(function webpackMissingModule() { var e = new Error(\"Cannot find module 'zipcode-city-distance'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }());\n\ndocument.addEventListener('DOMContentLoaded', function () {\n  // Get the form element\n  var distanceForm = document.getElementById('zip-distance-form');\n  if (distanceForm) {\n    distanceForm.addEventListener('submit', function (e) {\n      e.preventDefault();\n      var userZip = document.getElementById('user-zip').value;\n      var baseZip = document.getElementById('base-zip').value; // Hidden field with ACF value\n\n      try {\n        var distance = Object(function webpackMissingModule() { var e = new Error(\"Cannot find module 'zipcode-city-distance'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(baseZip, userZip);\n        var resultDiv = document.getElementById('distance-result');\n        resultDiv.textContent = \"Distance: \".concat(Math.round(distance), \" miles\");\n      } catch (error) {\n        console.error('Error calculating distance:', error);\n        var _resultDiv = document.getElementById('distance-result');\n        _resultDiv.textContent = 'Invalid zip code entered';\n      }\n    });\n  }\n});\n\n//# sourceURL=webpack://houstonsafeandlock/./wp-content/themes/locks/js/distance-calculator.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./wp-content/themes/locks/js/distance-calculator.js"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;