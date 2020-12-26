/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./env/webpack.importer.js":
/*!*********************************!*\
  !*** ./env/webpack.importer.js ***!
  \*********************************/
/***/ ((module) => {

function importAll(req) {
  let targets = {};
  req.keys().forEach(item => { targets[item.replace('./', '')] = req(item); });
  //console.log('targets', targets);
  return targets;
}

function importer(fileImports) {
  const imported = [];
  for (let req of fileImports) {
    imported.push(importAll(req));
  }

  return imported;
}

module.exports = importer;

/***/ }),

/***/ "./src/Attach/Fonts/OpenSans-Light.ttf":
/*!*********************************************!*\
  !*** ./src/Attach/Fonts/OpenSans-Light.ttf ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/OpenSans-Light.ttf");

/***/ }),

/***/ "./src/Attach/Fonts/OpenSans-LightItalic.ttf":
/*!***************************************************!*\
  !*** ./src/Attach/Fonts/OpenSans-LightItalic.ttf ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/OpenSans-LightItalic.ttf");

/***/ }),

/***/ "./src/Attach/Fonts/OpenSans-Regular.ttf":
/*!***********************************************!*\
  !*** ./src/Attach/Fonts/OpenSans-Regular.ttf ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/OpenSans-Regular.ttf");

/***/ }),

/***/ "./src/Attach/Fonts/more/OpenSans-Bold.ttf":
/*!*************************************************!*\
  !*** ./src/Attach/Fonts/more/OpenSans-Bold.ttf ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/more/OpenSans-Bold.ttf");

/***/ }),

/***/ "./src/Attach/Fonts/more/OpenSans-BoldItalic.ttf":
/*!*******************************************************!*\
  !*** ./src/Attach/Fonts/more/OpenSans-BoldItalic.ttf ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/more/OpenSans-BoldItalic.ttf");

/***/ }),

/***/ "./src/Attach/Fonts/more/OpenSans-ExtraBold.ttf":
/*!******************************************************!*\
  !*** ./src/Attach/Fonts/more/OpenSans-ExtraBold.ttf ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/more/OpenSans-ExtraBold.ttf");

/***/ }),

/***/ "./src/Attach/Fonts/more/OpenSans-ExtraBoldItalic.ttf":
/*!************************************************************!*\
  !*** ./src/Attach/Fonts/more/OpenSans-ExtraBoldItalic.ttf ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/more/OpenSans-ExtraBoldItalic.ttf");

/***/ }),

/***/ "./src/Attach/Fonts/more/OpenSans-Italic.ttf":
/*!***************************************************!*\
  !*** ./src/Attach/Fonts/more/OpenSans-Italic.ttf ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/more/OpenSans-Italic.ttf");

/***/ }),

/***/ "./src/Attach/Fonts/more/OpenSans-SemiBold.ttf":
/*!*****************************************************!*\
  !*** ./src/Attach/Fonts/more/OpenSans-SemiBold.ttf ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/more/OpenSans-SemiBold.ttf");

/***/ }),

/***/ "./src/Attach/Fonts/more/OpenSans-SemiBoldItalic.ttf":
/*!***********************************************************!*\
  !*** ./src/Attach/Fonts/more/OpenSans-SemiBoldItalic.ttf ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Fonts/more/OpenSans-SemiBoldItalic.ttf");

/***/ }),

/***/ "./src/Attach/Images/back.jpg":
/*!************************************!*\
  !*** ./src/Attach/Images/back.jpg ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/back.jpg");

/***/ }),

/***/ "./src/Attach/Images/background-login.png":
/*!************************************************!*\
  !*** ./src/Attach/Images/background-login.png ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/background-login.png");

/***/ }),

/***/ "./src/Attach/Images/boat1.jpg":
/*!*************************************!*\
  !*** ./src/Attach/Images/boat1.jpg ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat1.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat10.jpg":
/*!**************************************!*\
  !*** ./src/Attach/Images/boat10.jpg ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat10.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat11.jpg":
/*!**************************************!*\
  !*** ./src/Attach/Images/boat11.jpg ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat11.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat2.jpg":
/*!*************************************!*\
  !*** ./src/Attach/Images/boat2.jpg ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat2.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat3.jpg":
/*!*************************************!*\
  !*** ./src/Attach/Images/boat3.jpg ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat3.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat4.jpg":
/*!*************************************!*\
  !*** ./src/Attach/Images/boat4.jpg ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat4.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat5.jpg":
/*!*************************************!*\
  !*** ./src/Attach/Images/boat5.jpg ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat5.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat6.jpg":
/*!*************************************!*\
  !*** ./src/Attach/Images/boat6.jpg ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat6.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat7.jpg":
/*!*************************************!*\
  !*** ./src/Attach/Images/boat7.jpg ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat7.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat8.jpg":
/*!*************************************!*\
  !*** ./src/Attach/Images/boat8.jpg ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat8.jpg");

/***/ }),

/***/ "./src/Attach/Images/boat9.jpg":
/*!*************************************!*\
  !*** ./src/Attach/Images/boat9.jpg ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/boat9.jpg");

/***/ }),

/***/ "./src/Attach/Images/button.jpg":
/*!**************************************!*\
  !*** ./src/Attach/Images/button.jpg ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/button.jpg");

/***/ }),

/***/ "./src/Attach/Images/diving-icon.svg":
/*!*******************************************!*\
  !*** ./src/Attach/Images/diving-icon.svg ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/diving-icon.svg");

/***/ }),

/***/ "./src/Attach/Images/fish-icon.svg":
/*!*****************************************!*\
  !*** ./src/Attach/Images/fish-icon.svg ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/fish-icon.svg");

/***/ }),

/***/ "./src/Attach/Images/food-icon.svg":
/*!*****************************************!*\
  !*** ./src/Attach/Images/food-icon.svg ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/food-icon.svg");

/***/ }),

/***/ "./src/Attach/Images/icon-nav-list.svg":
/*!*********************************************!*\
  !*** ./src/Attach/Images/icon-nav-list.svg ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/icon-nav-list.svg");

/***/ }),

/***/ "./src/Attach/Images/icon-nav-map.svg":
/*!********************************************!*\
  !*** ./src/Attach/Images/icon-nav-map.svg ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/icon-nav-map.svg");

/***/ }),

/***/ "./src/Attach/Images/icon-nav-settings.svg":
/*!*************************************************!*\
  !*** ./src/Attach/Images/icon-nav-settings.svg ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/icon-nav-settings.svg");

/***/ }),

/***/ "./src/Attach/Images/logo-dark.svg":
/*!*****************************************!*\
  !*** ./src/Attach/Images/logo-dark.svg ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/logo-dark.svg");

/***/ }),

/***/ "./src/Attach/Images/logo-light.svg":
/*!******************************************!*\
  !*** ./src/Attach/Images/logo-light.svg ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("./../../../Attach/Images/logo-light.svg");

/***/ }),

/***/ "./node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet[1].rules[1].use[1]!./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[1].use[2]!./node_modules/postcss-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./src/Pages/index/index.sass":
/*!*************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet[1].rules[1].use[1]!./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[1].use[2]!./node_modules/postcss-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./src/Pages/index/index.sass ***!
  \*************************************************************************************************************************************************************************************************************************************************************************/
/***/ (() => {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./src/Pages/index/index.sass":
/*!************************************!*\
  !*** ./src/Pages/index/index.sass ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_1_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_1_use_2_node_modules_postcss_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_index_sass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet[1].rules[1].use[1]!../../../node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[1].use[2]!../../../node_modules/postcss-loader/dist/cjs.js!../../../node_modules/sass-loader/dist/cjs.js!./index.sass */ "./node_modules/mini-css-extract-plugin/dist/loader.js??ruleSet[1].rules[1].use[1]!./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[1].use[2]!./node_modules/postcss-loader/dist/cjs.js!./node_modules/sass-loader/dist/cjs.js!./src/Pages/index/index.sass");
/* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_1_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_1_use_2_node_modules_postcss_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_index_sass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_1_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_1_use_2_node_modules_postcss_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_index_sass__WEBPACK_IMPORTED_MODULE_1__);

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()((_node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_1_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_1_use_2_node_modules_postcss_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_index_sass__WEBPACK_IMPORTED_MODULE_1___default()), options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((_node_modules_mini_css_extract_plugin_dist_loader_js_ruleSet_1_rules_1_use_1_node_modules_css_loader_dist_cjs_js_ruleSet_1_rules_1_use_2_node_modules_postcss_loader_dist_cjs_js_node_modules_sass_loader_dist_cjs_js_index_sass__WEBPACK_IMPORTED_MODULE_1___default().locals) || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var isOldIE = function isOldIE() {
  var memo;
  return function memorize() {
    if (typeof memo === 'undefined') {
      // Test for IE <= 9 as proposed by Browserhacks
      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
      // Tests for existence of standard globals is to allow style-loader
      // to operate correctly into non-standard environments
      // @see https://github.com/webpack-contrib/style-loader/issues/177
      memo = Boolean(window && document && document.all && !window.atob);
    }

    return memo;
  };
}();

var getTarget = function getTarget() {
  var memo = {};
  return function memorize(target) {
    if (typeof memo[target] === 'undefined') {
      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself

      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
        try {
          // This will throw an exception if access to iframe is blocked
          // due to cross-origin restrictions
          styleTarget = styleTarget.contentDocument.head;
        } catch (e) {
          // istanbul ignore next
          styleTarget = null;
        }
      }

      memo[target] = styleTarget;
    }

    return memo[target];
  };
}();

var stylesInDom = [];

function getIndexByIdentifier(identifier) {
  var result = -1;

  for (var i = 0; i < stylesInDom.length; i++) {
    if (stylesInDom[i].identifier === identifier) {
      result = i;
      break;
    }
  }

  return result;
}

function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];

  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var index = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3]
    };

    if (index !== -1) {
      stylesInDom[index].references++;
      stylesInDom[index].updater(obj);
    } else {
      stylesInDom.push({
        identifier: identifier,
        updater: addStyle(obj, options),
        references: 1
      });
    }

    identifiers.push(identifier);
  }

  return identifiers;
}

function insertStyleElement(options) {
  var style = document.createElement('style');
  var attributes = options.attributes || {};

  if (typeof attributes.nonce === 'undefined') {
    var nonce =  true ? __webpack_require__.nc : 0;

    if (nonce) {
      attributes.nonce = nonce;
    }
  }

  Object.keys(attributes).forEach(function (key) {
    style.setAttribute(key, attributes[key]);
  });

  if (typeof options.insert === 'function') {
    options.insert(style);
  } else {
    var target = getTarget(options.insert || 'head');

    if (!target) {
      throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
    }

    target.appendChild(style);
  }

  return style;
}

function removeStyleElement(style) {
  // istanbul ignore if
  if (style.parentNode === null) {
    return false;
  }

  style.parentNode.removeChild(style);
}
/* istanbul ignore next  */


var replaceText = function replaceText() {
  var textStore = [];
  return function replace(index, replacement) {
    textStore[index] = replacement;
    return textStore.filter(Boolean).join('\n');
  };
}();

function applyToSingletonTag(style, index, remove, obj) {
  var css = remove ? '' : obj.media ? "@media ".concat(obj.media, " {").concat(obj.css, "}") : obj.css; // For old IE

  /* istanbul ignore if  */

  if (style.styleSheet) {
    style.styleSheet.cssText = replaceText(index, css);
  } else {
    var cssNode = document.createTextNode(css);
    var childNodes = style.childNodes;

    if (childNodes[index]) {
      style.removeChild(childNodes[index]);
    }

    if (childNodes.length) {
      style.insertBefore(cssNode, childNodes[index]);
    } else {
      style.appendChild(cssNode);
    }
  }
}

function applyToTag(style, options, obj) {
  var css = obj.css;
  var media = obj.media;
  var sourceMap = obj.sourceMap;

  if (media) {
    style.setAttribute('media', media);
  } else {
    style.removeAttribute('media');
  }

  if (sourceMap && typeof btoa !== 'undefined') {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  } // For old IE

  /* istanbul ignore if  */


  if (style.styleSheet) {
    style.styleSheet.cssText = css;
  } else {
    while (style.firstChild) {
      style.removeChild(style.firstChild);
    }

    style.appendChild(document.createTextNode(css));
  }
}

var singleton = null;
var singletonCounter = 0;

function addStyle(obj, options) {
  var style;
  var update;
  var remove;

  if (options.singleton) {
    var styleIndex = singletonCounter++;
    style = singleton || (singleton = insertStyleElement(options));
    update = applyToSingletonTag.bind(null, style, styleIndex, false);
    remove = applyToSingletonTag.bind(null, style, styleIndex, true);
  } else {
    style = insertStyleElement(options);
    update = applyToTag.bind(null, style, options);

    remove = function remove() {
      removeStyleElement(style);
    };
  }

  update(obj);
  return function updateStyle(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {
        return;
      }

      update(obj = newObj);
    } else {
      remove();
    }
  };
}

module.exports = function (list, options) {
  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
  // tags it will allow on a page

  if (!options.singleton && typeof options.singleton !== 'boolean') {
    options.singleton = isOldIE();
  }

  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];

    if (Object.prototype.toString.call(newList) !== '[object Array]') {
      return;
    }

    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDom[index].references--;
    }

    var newLastIdentifiers = modulesToDom(newList, options);

    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];

      var _index = getIndexByIdentifier(_identifier);

      if (stylesInDom[_index].references === 0) {
        stylesInDom[_index].updater();

        stylesInDom.splice(_index, 1);
      }
    }

    lastIdentifiers = newLastIdentifiers;
  };
};

/***/ }),

/***/ "./src/Attach sync recursive \\.":
/*!*****************************!*\
  !*** ./src/Attach/ sync \. ***!
  \*****************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var map = {
	"./Fonts/OpenSans-Light.ttf": "./src/Attach/Fonts/OpenSans-Light.ttf",
	"./Fonts/OpenSans-LightItalic.ttf": "./src/Attach/Fonts/OpenSans-LightItalic.ttf",
	"./Fonts/OpenSans-Regular.ttf": "./src/Attach/Fonts/OpenSans-Regular.ttf",
	"./Fonts/more/OpenSans-Bold.ttf": "./src/Attach/Fonts/more/OpenSans-Bold.ttf",
	"./Fonts/more/OpenSans-BoldItalic.ttf": "./src/Attach/Fonts/more/OpenSans-BoldItalic.ttf",
	"./Fonts/more/OpenSans-ExtraBold.ttf": "./src/Attach/Fonts/more/OpenSans-ExtraBold.ttf",
	"./Fonts/more/OpenSans-ExtraBoldItalic.ttf": "./src/Attach/Fonts/more/OpenSans-ExtraBoldItalic.ttf",
	"./Fonts/more/OpenSans-Italic.ttf": "./src/Attach/Fonts/more/OpenSans-Italic.ttf",
	"./Fonts/more/OpenSans-SemiBold.ttf": "./src/Attach/Fonts/more/OpenSans-SemiBold.ttf",
	"./Fonts/more/OpenSans-SemiBoldItalic.ttf": "./src/Attach/Fonts/more/OpenSans-SemiBoldItalic.ttf",
	"./Images/back.jpg": "./src/Attach/Images/back.jpg",
	"./Images/background-login.png": "./src/Attach/Images/background-login.png",
	"./Images/boat1.jpg": "./src/Attach/Images/boat1.jpg",
	"./Images/boat10.jpg": "./src/Attach/Images/boat10.jpg",
	"./Images/boat11.jpg": "./src/Attach/Images/boat11.jpg",
	"./Images/boat2.jpg": "./src/Attach/Images/boat2.jpg",
	"./Images/boat3.jpg": "./src/Attach/Images/boat3.jpg",
	"./Images/boat4.jpg": "./src/Attach/Images/boat4.jpg",
	"./Images/boat5.jpg": "./src/Attach/Images/boat5.jpg",
	"./Images/boat6.jpg": "./src/Attach/Images/boat6.jpg",
	"./Images/boat7.jpg": "./src/Attach/Images/boat7.jpg",
	"./Images/boat8.jpg": "./src/Attach/Images/boat8.jpg",
	"./Images/boat9.jpg": "./src/Attach/Images/boat9.jpg",
	"./Images/button.jpg": "./src/Attach/Images/button.jpg",
	"./Images/diving-icon.svg": "./src/Attach/Images/diving-icon.svg",
	"./Images/fish-icon.svg": "./src/Attach/Images/fish-icon.svg",
	"./Images/food-icon.svg": "./src/Attach/Images/food-icon.svg",
	"./Images/icon-nav-list.svg": "./src/Attach/Images/icon-nav-list.svg",
	"./Images/icon-nav-map.svg": "./src/Attach/Images/icon-nav-map.svg",
	"./Images/icon-nav-settings.svg": "./src/Attach/Images/icon-nav-settings.svg",
	"./Images/logo-dark.svg": "./src/Attach/Images/logo-dark.svg",
	"./Images/logo-light.svg": "./src/Attach/Images/logo-light.svg"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./src/Attach sync recursive \\.";

/***/ }),

/***/ "./src/Basic/button/button.js":
/*!************************************!*\
  !*** ./src/Basic/button/button.js ***!
  \************************************/
/***/ (() => {

//$(document).ready(() => {
//   const pref = '.button'; // prefix for current folder
//   
//   $(pref+'')
//});

/***/ }),

/***/ "./src/Basic/devicer/devicer.js":
/*!**************************************!*\
  !*** ./src/Basic/devicer/devicer.js ***!
  \**************************************/
/***/ (() => {

//$(document).ready(() => {
//   const pref = '.devicer'; // prefix for current folder
//   
//   $(pref+'')
//});

/***/ }),

/***/ "./src/Basic/input/input.js":
/*!**********************************!*\
  !*** ./src/Basic/input/input.js ***!
  \**********************************/
/***/ (() => {

//$(document).ready(() => {
//   const pref = '.input'; // prefix for current folder
//   
//   $(pref+'')
//});

/***/ }),

/***/ "./src/Basic/link/link.js":
/*!********************************!*\
  !*** ./src/Basic/link/link.js ***!
  \********************************/
/***/ (() => {

//$(document).ready(() => {
//   const pref = '.link'; // prefix for current folder
//   
//   $(pref+'')
//});

/***/ }),

/***/ "./src/Blocks/panel-main/panel-main.js":
/*!*********************************************!*\
  !*** ./src/Blocks/panel-main/panel-main.js ***!
  \*********************************************/
/***/ (() => {

//$(document).ready(() => {
//   const pref = '.panel-main'; // prefix for current folder
//   
//   $(pref+'')
//});

/***/ }),

/***/ "./src/Blocks/panel-nav/__button/panel-nav__button.js":
/*!************************************************************!*\
  !*** ./src/Blocks/panel-nav/__button/panel-nav__button.js ***!
  \************************************************************/
/***/ (() => {

//$(document).ready(() => {
//   const pref = '.panel-nav__button'; // prefix for current folder
//   
//   $(pref+'')
//});

/***/ }),

/***/ "./src/Blocks/panel-nav/panel-nav.js":
/*!*******************************************!*\
  !*** ./src/Blocks/panel-nav/panel-nav.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _button_panel_nav_button__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./__button/panel-nav__button */ "./src/Blocks/panel-nav/__button/panel-nav__button.js");
/* harmony import */ var _button_panel_nav_button__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_button_panel_nav_button__WEBPACK_IMPORTED_MODULE_0__);

//$(document).ready(() => {
//   const pref = '.panel-nav'; // prefix for current folder
//   
//   $(pref+'')
//});

/***/ }),

/***/ "./src/Logic/core.js":
/*!***************************!*\
  !*** ./src/Logic/core.js ***!
  \***************************/
/***/ (() => {



/***/ }),

/***/ "./src/Logic sync recursive \\.js$":
/*!*******************************!*\
  !*** ./src/Logic/ sync \.js$ ***!
  \*******************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var map = {
	"./core.js": "./src/Logic/core.js"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./src/Logic sync recursive \\.js$";

/***/ }),

/***/ "./src/Pages/index/index.js":
/*!**********************************!*\
  !*** ./src/Pages/index/index.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _bundle__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./../../bundle */ "./src/bundle.js");
/* harmony import */ var _Plugins_eventone_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../Plugins/eventone.js */ "./src/Plugins/eventone.js");


// Code libs and plugins


(0,_Plugins_eventone_js__WEBPACK_IMPORTED_MODULE_1__.globalEventone)();

/***/ }),

/***/ "./src/Plugins/eventone.js":
/*!*********************************!*\
  !*** ./src/Plugins/eventone.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "globalEventone": () => /* binding */ globalEventone
/* harmony export */ });
const __EVENTONE__ = {};

function action(label, inPlaceCallback) {
  return function (...args) {
    let reactors;
    if (__EVENTONE__[label]) // giving shorten name
      reactors = __EVENTONE__[label];

    if (reactors) {
      // reactors before main reactor
      if (Array.isArray(reactors.before) && reactors.before.length > 0)
        reactors.before.forEach(([, reactor]) => reactor(...args));
      // main reactor with 0 callPlace
      if (inPlaceCallback)
        inPlaceCallback(...args);
      // reactors after main reactor
      if (Array.isArray(reactors.after) && reactors.after.length > 0)
        reactors.after.forEach(([, reactor]) => reactor(...args));

    } else if (inPlaceCallback) {
      inPlaceCallback(...args); //just main reactor call
    }
  };
}

function when(actionLabel, reactor, callPlace = 0) {
  if (typeof actionLabel == 'string') {
    whenLogic(actionLabel);
  } else if (Array.isArray(actionLabel)) {
    for (let singleActionLabel of actionLabel) {
      whenLogic(singleActionLabel);
    }
  }

  function whenLogic(actionLabel) {
    let placeDimension = callPlace < 0 ? 'before' : 'after';
    if (!__EVENTONE__[actionLabel]) // check actionLabel exist
      __EVENTONE__[actionLabel] = {}; // create if not
    if (!Array.isArray(__EVENTONE__[actionLabel][placeDimension])) // check dimension is Array
      __EVENTONE__[actionLabel][placeDimension] = []; // create if not

    __EVENTONE__[actionLabel][placeDimension].push([callPlace, reactor]); // pushing reactor inside
    __EVENTONE__[actionLabel][placeDimension].sort((a, b) => a[0] - b[0]); // sorting reactors by callPlace
  }
}

function globalEventone() {
  window.__EVENTONE__ = __EVENTONE__;
  window.action = action;
  window.when = when;
}

/***/ }),

/***/ "./src/bundle.js":
/*!***********************!*\
  !*** ./src/bundle.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Basic_devicer_devicer__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Basic/devicer/devicer */ "./src/Basic/devicer/devicer.js");
/* harmony import */ var _Basic_devicer_devicer__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_Basic_devicer_devicer__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Basic_input_input__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Basic/input/input */ "./src/Basic/input/input.js");
/* harmony import */ var _Basic_input_input__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_Basic_input_input__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _Basic_button_button__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Basic/button/button */ "./src/Basic/button/button.js");
/* harmony import */ var _Basic_button_button__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_Basic_button_button__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _Basic_link_link__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Basic/link/link */ "./src/Basic/link/link.js");
/* harmony import */ var _Basic_link_link__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_Basic_link_link__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _Blocks_panel_main_panel_main__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Blocks/panel-main/panel-main */ "./src/Blocks/panel-main/panel-main.js");
/* harmony import */ var _Blocks_panel_main_panel_main__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_Blocks_panel_main_panel_main__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _Blocks_panel_nav_panel_nav__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./Blocks/panel-nav/panel-nav */ "./src/Blocks/panel-nav/panel-nav.js");
const importer = __webpack_require__(/*! ../env/webpack.importer */ "./env/webpack.importer.js");

const imported = importer([
  __webpack_require__("./src/Logic sync recursive \\.js$"),
  __webpack_require__("./src/Attach sync recursive \\."),
]);









/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => module['default'] :
/******/ 				() => module;
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => Object.prototype.hasOwnProperty.call(obj, prop)
/******/ 	})();
/******/ 	
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
/******/ 	// startup
/******/ 	// Load entry module
/******/ 	__webpack_require__("./src/Pages/index/index.js");
/******/ 	// This entry module used 'exports' so it can't be inlined
/******/ 	__webpack_require__("./src/Pages/index/index.sass");
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly92b2RvcG9qLy4vZW52L3dlYnBhY2suaW1wb3J0ZXIuanMiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9BdHRhY2gvRm9udHMvT3BlblNhbnMtTGlnaHQudHRmIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ZvbnRzL09wZW5TYW5zLUxpZ2h0SXRhbGljLnR0ZiIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9Gb250cy9PcGVuU2Fucy1SZWd1bGFyLnR0ZiIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9Gb250cy9tb3JlL09wZW5TYW5zLUJvbGQudHRmIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ZvbnRzL21vcmUvT3BlblNhbnMtQm9sZEl0YWxpYy50dGYiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9BdHRhY2gvRm9udHMvbW9yZS9PcGVuU2Fucy1FeHRyYUJvbGQudHRmIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ZvbnRzL21vcmUvT3BlblNhbnMtRXh0cmFCb2xkSXRhbGljLnR0ZiIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9Gb250cy9tb3JlL09wZW5TYW5zLUl0YWxpYy50dGYiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9BdHRhY2gvRm9udHMvbW9yZS9PcGVuU2Fucy1TZW1pQm9sZC50dGYiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9BdHRhY2gvRm9udHMvbW9yZS9PcGVuU2Fucy1TZW1pQm9sZEl0YWxpYy50dGYiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9BdHRhY2gvSW1hZ2VzL2JhY2suanBnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9iYWNrZ3JvdW5kLWxvZ2luLnBuZyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9JbWFnZXMvYm9hdDEuanBnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9ib2F0MTAuanBnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9ib2F0MTEuanBnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9ib2F0Mi5qcGciLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9BdHRhY2gvSW1hZ2VzL2JvYXQzLmpwZyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9JbWFnZXMvYm9hdDQuanBnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9ib2F0NS5qcGciLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9BdHRhY2gvSW1hZ2VzL2JvYXQ2LmpwZyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9JbWFnZXMvYm9hdDcuanBnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9ib2F0OC5qcGciLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9BdHRhY2gvSW1hZ2VzL2JvYXQ5LmpwZyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9JbWFnZXMvYnV0dG9uLmpwZyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9JbWFnZXMvZGl2aW5nLWljb24uc3ZnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9maXNoLWljb24uc3ZnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9mb29kLWljb24uc3ZnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9pY29uLW5hdi1saXN0LnN2ZyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9JbWFnZXMvaWNvbi1uYXYtbWFwLnN2ZyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0F0dGFjaC9JbWFnZXMvaWNvbi1uYXYtc2V0dGluZ3Muc3ZnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9sb2dvLWRhcmsuc3ZnIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQXR0YWNoL0ltYWdlcy9sb2dvLWxpZ2h0LnN2ZyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL1BhZ2VzL2luZGV4L2luZGV4LnNhc3M/NTg4MCIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL1BhZ2VzL2luZGV4L2luZGV4LnNhc3M/ZGNmOSIsIndlYnBhY2s6Ly92b2RvcG9qLy4vbm9kZV9tb2R1bGVzL3N0eWxlLWxvYWRlci9kaXN0L3J1bnRpbWUvaW5qZWN0U3R5bGVzSW50b1N0eWxlVGFnLmpzIiwid2VicGFjazovL3ZvZG9wb2ovL3Zhci93d3cvaHRtbC9qdXN0LWZpZWxkL3NyYy9BdHRhY2h8c3luY3wvXFwuLyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0Jhc2ljL2J1dHRvbi9idXR0b24uanMiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9CYXNpYy9kZXZpY2VyL2RldmljZXIuanMiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9CYXNpYy9pbnB1dC9pbnB1dC5qcyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0Jhc2ljL2xpbmsvbGluay5qcyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL0Jsb2Nrcy9wYW5lbC1tYWluL3BhbmVsLW1haW4uanMiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9CbG9ja3MvcGFuZWwtbmF2L19fYnV0dG9uL3BhbmVsLW5hdl9fYnV0dG9uLmpzIiwid2VicGFjazovL3ZvZG9wb2ovLi9zcmMvQmxvY2tzL3BhbmVsLW5hdi9wYW5lbC1uYXYuanMiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8vdmFyL3d3dy9odG1sL2p1c3QtZmllbGQvc3JjL0xvZ2ljfHN5bmN8L1xcLmpzJC8iLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9QYWdlcy9pbmRleC9pbmRleC5qcyIsIndlYnBhY2s6Ly92b2RvcG9qLy4vc3JjL1BsdWdpbnMvZXZlbnRvbmUuanMiLCJ3ZWJwYWNrOi8vdm9kb3Bvai8uL3NyYy9idW5kbGUuanMiLCJ3ZWJwYWNrOi8vdm9kb3Bvai93ZWJwYWNrL2Jvb3RzdHJhcCIsIndlYnBhY2s6Ly92b2RvcG9qL3dlYnBhY2svcnVudGltZS9jb21wYXQgZ2V0IGRlZmF1bHQgZXhwb3J0Iiwid2VicGFjazovL3ZvZG9wb2ovd2VicGFjay9ydW50aW1lL2RlZmluZSBwcm9wZXJ0eSBnZXR0ZXJzIiwid2VicGFjazovL3ZvZG9wb2ovd2VicGFjay9ydW50aW1lL2hhc093blByb3BlcnR5IHNob3J0aGFuZCIsIndlYnBhY2s6Ly92b2RvcG9qL3dlYnBhY2svcnVudGltZS9tYWtlIG5hbWVzcGFjZSBvYmplY3QiLCJ3ZWJwYWNrOi8vdm9kb3Bvai93ZWJwYWNrL3N0YXJ0dXAiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBLDhCQUE4Qiw2Q0FBNkMsRUFBRTtBQUM3RTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBLDBCOzs7Ozs7Ozs7Ozs7Ozs7QUNoQkEsaUVBQWUsNENBQTRDLEU7Ozs7Ozs7Ozs7Ozs7OztBQ0EzRCxpRUFBZSxrREFBa0QsRTs7Ozs7Ozs7Ozs7Ozs7O0FDQWpFLGlFQUFlLDhDQUE4QyxFOzs7Ozs7Ozs7Ozs7Ozs7QUNBN0QsaUVBQWUsZ0RBQWdELEU7Ozs7Ozs7Ozs7Ozs7OztBQ0EvRCxpRUFBZSxzREFBc0QsRTs7Ozs7Ozs7Ozs7Ozs7O0FDQXJFLGlFQUFlLHFEQUFxRCxFOzs7Ozs7Ozs7Ozs7Ozs7QUNBcEUsaUVBQWUsMkRBQTJELEU7Ozs7Ozs7Ozs7Ozs7OztBQ0ExRSxpRUFBZSxrREFBa0QsRTs7Ozs7Ozs7Ozs7Ozs7O0FDQWpFLGlFQUFlLG9EQUFvRCxFOzs7Ozs7Ozs7Ozs7Ozs7QUNBbkUsaUVBQWUsMERBQTBELEU7Ozs7Ozs7Ozs7Ozs7OztBQ0F6RSxpRUFBZSxtQ0FBbUMsRTs7Ozs7Ozs7Ozs7Ozs7O0FDQWxELGlFQUFlLCtDQUErQyxFOzs7Ozs7Ozs7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d0MseUNBQXlDO1dBQ2pGO1dBQ0E7V0FDQSxFOzs7OztXQ1BBLHNGOzs7OztXQ0FBO1dBQ0E7V0FDQTtXQUNBLHNEQUFzRCxrQkFBa0I7V0FDeEU7V0FDQSwrQ0FBK0MsY0FBYztXQUM3RCxFOzs7O1VDTkE7VUFDQTtVQUNBO1VBQ0E7VUFDQSIsImZpbGUiOiIuL3NyYy9QYWdlcy9pbmRleC9kaXN0L2luZGV4LmJ1bmRsZS5qcyIsInNvdXJjZXNDb250ZW50IjpbImZ1bmN0aW9uIGltcG9ydEFsbChyZXEpIHtcbiAgbGV0IHRhcmdldHMgPSB7fTtcbiAgcmVxLmtleXMoKS5mb3JFYWNoKGl0ZW0gPT4geyB0YXJnZXRzW2l0ZW0ucmVwbGFjZSgnLi8nLCAnJyldID0gcmVxKGl0ZW0pOyB9KTtcbiAgLy9jb25zb2xlLmxvZygndGFyZ2V0cycsIHRhcmdldHMpO1xuICByZXR1cm4gdGFyZ2V0cztcbn1cblxuZnVuY3Rpb24gaW1wb3J0ZXIoZmlsZUltcG9ydHMpIHtcbiAgY29uc3QgaW1wb3J0ZWQgPSBbXTtcbiAgZm9yIChsZXQgcmVxIG9mIGZpbGVJbXBvcnRzKSB7XG4gICAgaW1wb3J0ZWQucHVzaChpbXBvcnRBbGwocmVxKSk7XG4gIH1cblxuICByZXR1cm4gaW1wb3J0ZWQ7XG59XG5cbm1vZHVsZS5leHBvcnRzID0gaW1wb3J0ZXI7IiwiZXhwb3J0IGRlZmF1bHQgXCIuLy4uLy4uLy4uL0F0dGFjaC9Gb250cy9PcGVuU2Fucy1MaWdodC50dGZcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ZvbnRzL09wZW5TYW5zLUxpZ2h0SXRhbGljLnR0ZlwiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvRm9udHMvT3BlblNhbnMtUmVndWxhci50dGZcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ZvbnRzL21vcmUvT3BlblNhbnMtQm9sZC50dGZcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ZvbnRzL21vcmUvT3BlblNhbnMtQm9sZEl0YWxpYy50dGZcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ZvbnRzL21vcmUvT3BlblNhbnMtRXh0cmFCb2xkLnR0ZlwiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvRm9udHMvbW9yZS9PcGVuU2Fucy1FeHRyYUJvbGRJdGFsaWMudHRmXCI7IiwiZXhwb3J0IGRlZmF1bHQgXCIuLy4uLy4uLy4uL0F0dGFjaC9Gb250cy9tb3JlL09wZW5TYW5zLUl0YWxpYy50dGZcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ZvbnRzL21vcmUvT3BlblNhbnMtU2VtaUJvbGQudHRmXCI7IiwiZXhwb3J0IGRlZmF1bHQgXCIuLy4uLy4uLy4uL0F0dGFjaC9Gb250cy9tb3JlL09wZW5TYW5zLVNlbWlCb2xkSXRhbGljLnR0ZlwiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2JhY2suanBnXCI7IiwiZXhwb3J0IGRlZmF1bHQgXCIuLy4uLy4uLy4uL0F0dGFjaC9JbWFnZXMvYmFja2dyb3VuZC1sb2dpbi5wbmdcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ltYWdlcy9ib2F0MS5qcGdcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ltYWdlcy9ib2F0MTAuanBnXCI7IiwiZXhwb3J0IGRlZmF1bHQgXCIuLy4uLy4uLy4uL0F0dGFjaC9JbWFnZXMvYm9hdDExLmpwZ1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2JvYXQyLmpwZ1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2JvYXQzLmpwZ1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2JvYXQ0LmpwZ1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2JvYXQ1LmpwZ1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2JvYXQ2LmpwZ1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2JvYXQ3LmpwZ1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2JvYXQ4LmpwZ1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2JvYXQ5LmpwZ1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2J1dHRvbi5qcGdcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ltYWdlcy9kaXZpbmctaWNvbi5zdmdcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ltYWdlcy9maXNoLWljb24uc3ZnXCI7IiwiZXhwb3J0IGRlZmF1bHQgXCIuLy4uLy4uLy4uL0F0dGFjaC9JbWFnZXMvZm9vZC1pY29uLnN2Z1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2ljb24tbmF2LWxpc3Quc3ZnXCI7IiwiZXhwb3J0IGRlZmF1bHQgXCIuLy4uLy4uLy4uL0F0dGFjaC9JbWFnZXMvaWNvbi1uYXYtbWFwLnN2Z1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2ljb24tbmF2LXNldHRpbmdzLnN2Z1wiOyIsImV4cG9ydCBkZWZhdWx0IFwiLi8uLi8uLi8uLi9BdHRhY2gvSW1hZ2VzL2xvZ28tZGFyay5zdmdcIjsiLCJleHBvcnQgZGVmYXVsdCBcIi4vLi4vLi4vLi4vQXR0YWNoL0ltYWdlcy9sb2dvLWxpZ2h0LnN2Z1wiOyIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsImltcG9ydCBhcGkgZnJvbSBcIiEuLi8uLi8uLi9ub2RlX21vZHVsZXMvc3R5bGUtbG9hZGVyL2Rpc3QvcnVudGltZS9pbmplY3RTdHlsZXNJbnRvU3R5bGVUYWcuanNcIjtcbiAgICAgICAgICAgIGltcG9ydCBjb250ZW50IGZyb20gXCIhIS4uLy4uLy4uL25vZGVfbW9kdWxlcy9taW5pLWNzcy1leHRyYWN0LXBsdWdpbi9kaXN0L2xvYWRlci5qcz8/cnVsZVNldFsxXS5ydWxlc1sxXS51c2VbMV0hLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2Nzcy1sb2FkZXIvZGlzdC9janMuanM/P3J1bGVTZXRbMV0ucnVsZXNbMV0udXNlWzJdIS4uLy4uLy4uL25vZGVfbW9kdWxlcy9wb3N0Y3NzLWxvYWRlci9kaXN0L2Nqcy5qcyEuLi8uLi8uLi9ub2RlX21vZHVsZXMvc2Fzcy1sb2FkZXIvZGlzdC9janMuanMhLi9pbmRleC5zYXNzXCI7XG5cbnZhciBvcHRpb25zID0ge307XG5cbm9wdGlvbnMuaW5zZXJ0ID0gXCJoZWFkXCI7XG5vcHRpb25zLnNpbmdsZXRvbiA9IGZhbHNlO1xuXG52YXIgdXBkYXRlID0gYXBpKGNvbnRlbnQsIG9wdGlvbnMpO1xuXG5cblxuZXhwb3J0IGRlZmF1bHQgY29udGVudC5sb2NhbHMgfHwge307IiwiXCJ1c2Ugc3RyaWN0XCI7XG5cbnZhciBpc09sZElFID0gZnVuY3Rpb24gaXNPbGRJRSgpIHtcbiAgdmFyIG1lbW87XG4gIHJldHVybiBmdW5jdGlvbiBtZW1vcml6ZSgpIHtcbiAgICBpZiAodHlwZW9mIG1lbW8gPT09ICd1bmRlZmluZWQnKSB7XG4gICAgICAvLyBUZXN0IGZvciBJRSA8PSA5IGFzIHByb3Bvc2VkIGJ5IEJyb3dzZXJoYWNrc1xuICAgICAgLy8gQHNlZSBodHRwOi8vYnJvd3NlcmhhY2tzLmNvbS8jaGFjay1lNzFkODY5MmY2NTMzNDE3M2ZlZTcxNWMyMjJjYjgwNVxuICAgICAgLy8gVGVzdHMgZm9yIGV4aXN0ZW5jZSBvZiBzdGFuZGFyZCBnbG9iYWxzIGlzIHRvIGFsbG93IHN0eWxlLWxvYWRlclxuICAgICAgLy8gdG8gb3BlcmF0ZSBjb3JyZWN0bHkgaW50byBub24tc3RhbmRhcmQgZW52aXJvbm1lbnRzXG4gICAgICAvLyBAc2VlIGh0dHBzOi8vZ2l0aHViLmNvbS93ZWJwYWNrLWNvbnRyaWIvc3R5bGUtbG9hZGVyL2lzc3Vlcy8xNzdcbiAgICAgIG1lbW8gPSBCb29sZWFuKHdpbmRvdyAmJiBkb2N1bWVudCAmJiBkb2N1bWVudC5hbGwgJiYgIXdpbmRvdy5hdG9iKTtcbiAgICB9XG5cbiAgICByZXR1cm4gbWVtbztcbiAgfTtcbn0oKTtcblxudmFyIGdldFRhcmdldCA9IGZ1bmN0aW9uIGdldFRhcmdldCgpIHtcbiAgdmFyIG1lbW8gPSB7fTtcbiAgcmV0dXJuIGZ1bmN0aW9uIG1lbW9yaXplKHRhcmdldCkge1xuICAgIGlmICh0eXBlb2YgbWVtb1t0YXJnZXRdID09PSAndW5kZWZpbmVkJykge1xuICAgICAgdmFyIHN0eWxlVGFyZ2V0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3Rvcih0YXJnZXQpOyAvLyBTcGVjaWFsIGNhc2UgdG8gcmV0dXJuIGhlYWQgb2YgaWZyYW1lIGluc3RlYWQgb2YgaWZyYW1lIGl0c2VsZlxuXG4gICAgICBpZiAod2luZG93LkhUTUxJRnJhbWVFbGVtZW50ICYmIHN0eWxlVGFyZ2V0IGluc3RhbmNlb2Ygd2luZG93LkhUTUxJRnJhbWVFbGVtZW50KSB7XG4gICAgICAgIHRyeSB7XG4gICAgICAgICAgLy8gVGhpcyB3aWxsIHRocm93IGFuIGV4Y2VwdGlvbiBpZiBhY2Nlc3MgdG8gaWZyYW1lIGlzIGJsb2NrZWRcbiAgICAgICAgICAvLyBkdWUgdG8gY3Jvc3Mtb3JpZ2luIHJlc3RyaWN0aW9uc1xuICAgICAgICAgIHN0eWxlVGFyZ2V0ID0gc3R5bGVUYXJnZXQuY29udGVudERvY3VtZW50LmhlYWQ7XG4gICAgICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgICAgICAvLyBpc3RhbmJ1bCBpZ25vcmUgbmV4dFxuICAgICAgICAgIHN0eWxlVGFyZ2V0ID0gbnVsbDtcbiAgICAgICAgfVxuICAgICAgfVxuXG4gICAgICBtZW1vW3RhcmdldF0gPSBzdHlsZVRhcmdldDtcbiAgICB9XG5cbiAgICByZXR1cm4gbWVtb1t0YXJnZXRdO1xuICB9O1xufSgpO1xuXG52YXIgc3R5bGVzSW5Eb20gPSBbXTtcblxuZnVuY3Rpb24gZ2V0SW5kZXhCeUlkZW50aWZpZXIoaWRlbnRpZmllcikge1xuICB2YXIgcmVzdWx0ID0gLTE7XG5cbiAgZm9yICh2YXIgaSA9IDA7IGkgPCBzdHlsZXNJbkRvbS5sZW5ndGg7IGkrKykge1xuICAgIGlmIChzdHlsZXNJbkRvbVtpXS5pZGVudGlmaWVyID09PSBpZGVudGlmaWVyKSB7XG4gICAgICByZXN1bHQgPSBpO1xuICAgICAgYnJlYWs7XG4gICAgfVxuICB9XG5cbiAgcmV0dXJuIHJlc3VsdDtcbn1cblxuZnVuY3Rpb24gbW9kdWxlc1RvRG9tKGxpc3QsIG9wdGlvbnMpIHtcbiAgdmFyIGlkQ291bnRNYXAgPSB7fTtcbiAgdmFyIGlkZW50aWZpZXJzID0gW107XG5cbiAgZm9yICh2YXIgaSA9IDA7IGkgPCBsaXN0Lmxlbmd0aDsgaSsrKSB7XG4gICAgdmFyIGl0ZW0gPSBsaXN0W2ldO1xuICAgIHZhciBpZCA9IG9wdGlvbnMuYmFzZSA/IGl0ZW1bMF0gKyBvcHRpb25zLmJhc2UgOiBpdGVtWzBdO1xuICAgIHZhciBjb3VudCA9IGlkQ291bnRNYXBbaWRdIHx8IDA7XG4gICAgdmFyIGlkZW50aWZpZXIgPSBcIlwiLmNvbmNhdChpZCwgXCIgXCIpLmNvbmNhdChjb3VudCk7XG4gICAgaWRDb3VudE1hcFtpZF0gPSBjb3VudCArIDE7XG4gICAgdmFyIGluZGV4ID0gZ2V0SW5kZXhCeUlkZW50aWZpZXIoaWRlbnRpZmllcik7XG4gICAgdmFyIG9iaiA9IHtcbiAgICAgIGNzczogaXRlbVsxXSxcbiAgICAgIG1lZGlhOiBpdGVtWzJdLFxuICAgICAgc291cmNlTWFwOiBpdGVtWzNdXG4gICAgfTtcblxuICAgIGlmIChpbmRleCAhPT0gLTEpIHtcbiAgICAgIHN0eWxlc0luRG9tW2luZGV4XS5yZWZlcmVuY2VzKys7XG4gICAgICBzdHlsZXNJbkRvbVtpbmRleF0udXBkYXRlcihvYmopO1xuICAgIH0gZWxzZSB7XG4gICAgICBzdHlsZXNJbkRvbS5wdXNoKHtcbiAgICAgICAgaWRlbnRpZmllcjogaWRlbnRpZmllcixcbiAgICAgICAgdXBkYXRlcjogYWRkU3R5bGUob2JqLCBvcHRpb25zKSxcbiAgICAgICAgcmVmZXJlbmNlczogMVxuICAgICAgfSk7XG4gICAgfVxuXG4gICAgaWRlbnRpZmllcnMucHVzaChpZGVudGlmaWVyKTtcbiAgfVxuXG4gIHJldHVybiBpZGVudGlmaWVycztcbn1cblxuZnVuY3Rpb24gaW5zZXJ0U3R5bGVFbGVtZW50KG9wdGlvbnMpIHtcbiAgdmFyIHN0eWxlID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnc3R5bGUnKTtcbiAgdmFyIGF0dHJpYnV0ZXMgPSBvcHRpb25zLmF0dHJpYnV0ZXMgfHwge307XG5cbiAgaWYgKHR5cGVvZiBhdHRyaWJ1dGVzLm5vbmNlID09PSAndW5kZWZpbmVkJykge1xuICAgIHZhciBub25jZSA9IHR5cGVvZiBfX3dlYnBhY2tfbm9uY2VfXyAhPT0gJ3VuZGVmaW5lZCcgPyBfX3dlYnBhY2tfbm9uY2VfXyA6IG51bGw7XG5cbiAgICBpZiAobm9uY2UpIHtcbiAgICAgIGF0dHJpYnV0ZXMubm9uY2UgPSBub25jZTtcbiAgICB9XG4gIH1cblxuICBPYmplY3Qua2V5cyhhdHRyaWJ1dGVzKS5mb3JFYWNoKGZ1bmN0aW9uIChrZXkpIHtcbiAgICBzdHlsZS5zZXRBdHRyaWJ1dGUoa2V5LCBhdHRyaWJ1dGVzW2tleV0pO1xuICB9KTtcblxuICBpZiAodHlwZW9mIG9wdGlvbnMuaW5zZXJ0ID09PSAnZnVuY3Rpb24nKSB7XG4gICAgb3B0aW9ucy5pbnNlcnQoc3R5bGUpO1xuICB9IGVsc2Uge1xuICAgIHZhciB0YXJnZXQgPSBnZXRUYXJnZXQob3B0aW9ucy5pbnNlcnQgfHwgJ2hlYWQnKTtcblxuICAgIGlmICghdGFyZ2V0KSB7XG4gICAgICB0aHJvdyBuZXcgRXJyb3IoXCJDb3VsZG4ndCBmaW5kIGEgc3R5bGUgdGFyZ2V0LiBUaGlzIHByb2JhYmx5IG1lYW5zIHRoYXQgdGhlIHZhbHVlIGZvciB0aGUgJ2luc2VydCcgcGFyYW1ldGVyIGlzIGludmFsaWQuXCIpO1xuICAgIH1cblxuICAgIHRhcmdldC5hcHBlbmRDaGlsZChzdHlsZSk7XG4gIH1cblxuICByZXR1cm4gc3R5bGU7XG59XG5cbmZ1bmN0aW9uIHJlbW92ZVN0eWxlRWxlbWVudChzdHlsZSkge1xuICAvLyBpc3RhbmJ1bCBpZ25vcmUgaWZcbiAgaWYgKHN0eWxlLnBhcmVudE5vZGUgPT09IG51bGwpIHtcbiAgICByZXR1cm4gZmFsc2U7XG4gIH1cblxuICBzdHlsZS5wYXJlbnROb2RlLnJlbW92ZUNoaWxkKHN0eWxlKTtcbn1cbi8qIGlzdGFuYnVsIGlnbm9yZSBuZXh0ICAqL1xuXG5cbnZhciByZXBsYWNlVGV4dCA9IGZ1bmN0aW9uIHJlcGxhY2VUZXh0KCkge1xuICB2YXIgdGV4dFN0b3JlID0gW107XG4gIHJldHVybiBmdW5jdGlvbiByZXBsYWNlKGluZGV4LCByZXBsYWNlbWVudCkge1xuICAgIHRleHRTdG9yZVtpbmRleF0gPSByZXBsYWNlbWVudDtcbiAgICByZXR1cm4gdGV4dFN0b3JlLmZpbHRlcihCb29sZWFuKS5qb2luKCdcXG4nKTtcbiAgfTtcbn0oKTtcblxuZnVuY3Rpb24gYXBwbHlUb1NpbmdsZXRvblRhZyhzdHlsZSwgaW5kZXgsIHJlbW92ZSwgb2JqKSB7XG4gIHZhciBjc3MgPSByZW1vdmUgPyAnJyA6IG9iai5tZWRpYSA/IFwiQG1lZGlhIFwiLmNvbmNhdChvYmoubWVkaWEsIFwiIHtcIikuY29uY2F0KG9iai5jc3MsIFwifVwiKSA6IG9iai5jc3M7IC8vIEZvciBvbGQgSUVcblxuICAvKiBpc3RhbmJ1bCBpZ25vcmUgaWYgICovXG5cbiAgaWYgKHN0eWxlLnN0eWxlU2hlZXQpIHtcbiAgICBzdHlsZS5zdHlsZVNoZWV0LmNzc1RleHQgPSByZXBsYWNlVGV4dChpbmRleCwgY3NzKTtcbiAgfSBlbHNlIHtcbiAgICB2YXIgY3NzTm9kZSA9IGRvY3VtZW50LmNyZWF0ZVRleHROb2RlKGNzcyk7XG4gICAgdmFyIGNoaWxkTm9kZXMgPSBzdHlsZS5jaGlsZE5vZGVzO1xuXG4gICAgaWYgKGNoaWxkTm9kZXNbaW5kZXhdKSB7XG4gICAgICBzdHlsZS5yZW1vdmVDaGlsZChjaGlsZE5vZGVzW2luZGV4XSk7XG4gICAgfVxuXG4gICAgaWYgKGNoaWxkTm9kZXMubGVuZ3RoKSB7XG4gICAgICBzdHlsZS5pbnNlcnRCZWZvcmUoY3NzTm9kZSwgY2hpbGROb2Rlc1tpbmRleF0pO1xuICAgIH0gZWxzZSB7XG4gICAgICBzdHlsZS5hcHBlbmRDaGlsZChjc3NOb2RlKTtcbiAgICB9XG4gIH1cbn1cblxuZnVuY3Rpb24gYXBwbHlUb1RhZyhzdHlsZSwgb3B0aW9ucywgb2JqKSB7XG4gIHZhciBjc3MgPSBvYmouY3NzO1xuICB2YXIgbWVkaWEgPSBvYmoubWVkaWE7XG4gIHZhciBzb3VyY2VNYXAgPSBvYmouc291cmNlTWFwO1xuXG4gIGlmIChtZWRpYSkge1xuICAgIHN0eWxlLnNldEF0dHJpYnV0ZSgnbWVkaWEnLCBtZWRpYSk7XG4gIH0gZWxzZSB7XG4gICAgc3R5bGUucmVtb3ZlQXR0cmlidXRlKCdtZWRpYScpO1xuICB9XG5cbiAgaWYgKHNvdXJjZU1hcCAmJiB0eXBlb2YgYnRvYSAhPT0gJ3VuZGVmaW5lZCcpIHtcbiAgICBjc3MgKz0gXCJcXG4vKiMgc291cmNlTWFwcGluZ1VSTD1kYXRhOmFwcGxpY2F0aW9uL2pzb247YmFzZTY0LFwiLmNvbmNhdChidG9hKHVuZXNjYXBlKGVuY29kZVVSSUNvbXBvbmVudChKU09OLnN0cmluZ2lmeShzb3VyY2VNYXApKSkpLCBcIiAqL1wiKTtcbiAgfSAvLyBGb3Igb2xkIElFXG5cbiAgLyogaXN0YW5idWwgaWdub3JlIGlmICAqL1xuXG5cbiAgaWYgKHN0eWxlLnN0eWxlU2hlZXQpIHtcbiAgICBzdHlsZS5zdHlsZVNoZWV0LmNzc1RleHQgPSBjc3M7XG4gIH0gZWxzZSB7XG4gICAgd2hpbGUgKHN0eWxlLmZpcnN0Q2hpbGQpIHtcbiAgICAgIHN0eWxlLnJlbW92ZUNoaWxkKHN0eWxlLmZpcnN0Q2hpbGQpO1xuICAgIH1cblxuICAgIHN0eWxlLmFwcGVuZENoaWxkKGRvY3VtZW50LmNyZWF0ZVRleHROb2RlKGNzcykpO1xuICB9XG59XG5cbnZhciBzaW5nbGV0b24gPSBudWxsO1xudmFyIHNpbmdsZXRvbkNvdW50ZXIgPSAwO1xuXG5mdW5jdGlvbiBhZGRTdHlsZShvYmosIG9wdGlvbnMpIHtcbiAgdmFyIHN0eWxlO1xuICB2YXIgdXBkYXRlO1xuICB2YXIgcmVtb3ZlO1xuXG4gIGlmIChvcHRpb25zLnNpbmdsZXRvbikge1xuICAgIHZhciBzdHlsZUluZGV4ID0gc2luZ2xldG9uQ291bnRlcisrO1xuICAgIHN0eWxlID0gc2luZ2xldG9uIHx8IChzaW5nbGV0b24gPSBpbnNlcnRTdHlsZUVsZW1lbnQob3B0aW9ucykpO1xuICAgIHVwZGF0ZSA9IGFwcGx5VG9TaW5nbGV0b25UYWcuYmluZChudWxsLCBzdHlsZSwgc3R5bGVJbmRleCwgZmFsc2UpO1xuICAgIHJlbW92ZSA9IGFwcGx5VG9TaW5nbGV0b25UYWcuYmluZChudWxsLCBzdHlsZSwgc3R5bGVJbmRleCwgdHJ1ZSk7XG4gIH0gZWxzZSB7XG4gICAgc3R5bGUgPSBpbnNlcnRTdHlsZUVsZW1lbnQob3B0aW9ucyk7XG4gICAgdXBkYXRlID0gYXBwbHlUb1RhZy5iaW5kKG51bGwsIHN0eWxlLCBvcHRpb25zKTtcblxuICAgIHJlbW92ZSA9IGZ1bmN0aW9uIHJlbW92ZSgpIHtcbiAgICAgIHJlbW92ZVN0eWxlRWxlbWVudChzdHlsZSk7XG4gICAgfTtcbiAgfVxuXG4gIHVwZGF0ZShvYmopO1xuICByZXR1cm4gZnVuY3Rpb24gdXBkYXRlU3R5bGUobmV3T2JqKSB7XG4gICAgaWYgKG5ld09iaikge1xuICAgICAgaWYgKG5ld09iai5jc3MgPT09IG9iai5jc3MgJiYgbmV3T2JqLm1lZGlhID09PSBvYmoubWVkaWEgJiYgbmV3T2JqLnNvdXJjZU1hcCA9PT0gb2JqLnNvdXJjZU1hcCkge1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG5cbiAgICAgIHVwZGF0ZShvYmogPSBuZXdPYmopO1xuICAgIH0gZWxzZSB7XG4gICAgICByZW1vdmUoKTtcbiAgICB9XG4gIH07XG59XG5cbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24gKGxpc3QsIG9wdGlvbnMpIHtcbiAgb3B0aW9ucyA9IG9wdGlvbnMgfHwge307IC8vIEZvcmNlIHNpbmdsZS10YWcgc29sdXRpb24gb24gSUU2LTksIHdoaWNoIGhhcyBhIGhhcmQgbGltaXQgb24gdGhlICMgb2YgPHN0eWxlPlxuICAvLyB0YWdzIGl0IHdpbGwgYWxsb3cgb24gYSBwYWdlXG5cbiAgaWYgKCFvcHRpb25zLnNpbmdsZXRvbiAmJiB0eXBlb2Ygb3B0aW9ucy5zaW5nbGV0b24gIT09ICdib29sZWFuJykge1xuICAgIG9wdGlvbnMuc2luZ2xldG9uID0gaXNPbGRJRSgpO1xuICB9XG5cbiAgbGlzdCA9IGxpc3QgfHwgW107XG4gIHZhciBsYXN0SWRlbnRpZmllcnMgPSBtb2R1bGVzVG9Eb20obGlzdCwgb3B0aW9ucyk7XG4gIHJldHVybiBmdW5jdGlvbiB1cGRhdGUobmV3TGlzdCkge1xuICAgIG5ld0xpc3QgPSBuZXdMaXN0IHx8IFtdO1xuXG4gICAgaWYgKE9iamVjdC5wcm90b3R5cGUudG9TdHJpbmcuY2FsbChuZXdMaXN0KSAhPT0gJ1tvYmplY3QgQXJyYXldJykge1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIGZvciAodmFyIGkgPSAwOyBpIDwgbGFzdElkZW50aWZpZXJzLmxlbmd0aDsgaSsrKSB7XG4gICAgICB2YXIgaWRlbnRpZmllciA9IGxhc3RJZGVudGlmaWVyc1tpXTtcbiAgICAgIHZhciBpbmRleCA9IGdldEluZGV4QnlJZGVudGlmaWVyKGlkZW50aWZpZXIpO1xuICAgICAgc3R5bGVzSW5Eb21baW5kZXhdLnJlZmVyZW5jZXMtLTtcbiAgICB9XG5cbiAgICB2YXIgbmV3TGFzdElkZW50aWZpZXJzID0gbW9kdWxlc1RvRG9tKG5ld0xpc3QsIG9wdGlvbnMpO1xuXG4gICAgZm9yICh2YXIgX2kgPSAwOyBfaSA8IGxhc3RJZGVudGlmaWVycy5sZW5ndGg7IF9pKyspIHtcbiAgICAgIHZhciBfaWRlbnRpZmllciA9IGxhc3RJZGVudGlmaWVyc1tfaV07XG5cbiAgICAgIHZhciBfaW5kZXggPSBnZXRJbmRleEJ5SWRlbnRpZmllcihfaWRlbnRpZmllcik7XG5cbiAgICAgIGlmIChzdHlsZXNJbkRvbVtfaW5kZXhdLnJlZmVyZW5jZXMgPT09IDApIHtcbiAgICAgICAgc3R5bGVzSW5Eb21bX2luZGV4XS51cGRhdGVyKCk7XG5cbiAgICAgICAgc3R5bGVzSW5Eb20uc3BsaWNlKF9pbmRleCwgMSk7XG4gICAgICB9XG4gICAgfVxuXG4gICAgbGFzdElkZW50aWZpZXJzID0gbmV3TGFzdElkZW50aWZpZXJzO1xuICB9O1xufTsiLCJ2YXIgbWFwID0ge1xuXHRcIi4vRm9udHMvT3BlblNhbnMtTGlnaHQudHRmXCI6IFwiLi9zcmMvQXR0YWNoL0ZvbnRzL09wZW5TYW5zLUxpZ2h0LnR0ZlwiLFxuXHRcIi4vRm9udHMvT3BlblNhbnMtTGlnaHRJdGFsaWMudHRmXCI6IFwiLi9zcmMvQXR0YWNoL0ZvbnRzL09wZW5TYW5zLUxpZ2h0SXRhbGljLnR0ZlwiLFxuXHRcIi4vRm9udHMvT3BlblNhbnMtUmVndWxhci50dGZcIjogXCIuL3NyYy9BdHRhY2gvRm9udHMvT3BlblNhbnMtUmVndWxhci50dGZcIixcblx0XCIuL0ZvbnRzL21vcmUvT3BlblNhbnMtQm9sZC50dGZcIjogXCIuL3NyYy9BdHRhY2gvRm9udHMvbW9yZS9PcGVuU2Fucy1Cb2xkLnR0ZlwiLFxuXHRcIi4vRm9udHMvbW9yZS9PcGVuU2Fucy1Cb2xkSXRhbGljLnR0ZlwiOiBcIi4vc3JjL0F0dGFjaC9Gb250cy9tb3JlL09wZW5TYW5zLUJvbGRJdGFsaWMudHRmXCIsXG5cdFwiLi9Gb250cy9tb3JlL09wZW5TYW5zLUV4dHJhQm9sZC50dGZcIjogXCIuL3NyYy9BdHRhY2gvRm9udHMvbW9yZS9PcGVuU2Fucy1FeHRyYUJvbGQudHRmXCIsXG5cdFwiLi9Gb250cy9tb3JlL09wZW5TYW5zLUV4dHJhQm9sZEl0YWxpYy50dGZcIjogXCIuL3NyYy9BdHRhY2gvRm9udHMvbW9yZS9PcGVuU2Fucy1FeHRyYUJvbGRJdGFsaWMudHRmXCIsXG5cdFwiLi9Gb250cy9tb3JlL09wZW5TYW5zLUl0YWxpYy50dGZcIjogXCIuL3NyYy9BdHRhY2gvRm9udHMvbW9yZS9PcGVuU2Fucy1JdGFsaWMudHRmXCIsXG5cdFwiLi9Gb250cy9tb3JlL09wZW5TYW5zLVNlbWlCb2xkLnR0ZlwiOiBcIi4vc3JjL0F0dGFjaC9Gb250cy9tb3JlL09wZW5TYW5zLVNlbWlCb2xkLnR0ZlwiLFxuXHRcIi4vRm9udHMvbW9yZS9PcGVuU2Fucy1TZW1pQm9sZEl0YWxpYy50dGZcIjogXCIuL3NyYy9BdHRhY2gvRm9udHMvbW9yZS9PcGVuU2Fucy1TZW1pQm9sZEl0YWxpYy50dGZcIixcblx0XCIuL0ltYWdlcy9iYWNrLmpwZ1wiOiBcIi4vc3JjL0F0dGFjaC9JbWFnZXMvYmFjay5qcGdcIixcblx0XCIuL0ltYWdlcy9iYWNrZ3JvdW5kLWxvZ2luLnBuZ1wiOiBcIi4vc3JjL0F0dGFjaC9JbWFnZXMvYmFja2dyb3VuZC1sb2dpbi5wbmdcIixcblx0XCIuL0ltYWdlcy9ib2F0MS5qcGdcIjogXCIuL3NyYy9BdHRhY2gvSW1hZ2VzL2JvYXQxLmpwZ1wiLFxuXHRcIi4vSW1hZ2VzL2JvYXQxMC5qcGdcIjogXCIuL3NyYy9BdHRhY2gvSW1hZ2VzL2JvYXQxMC5qcGdcIixcblx0XCIuL0ltYWdlcy9ib2F0MTEuanBnXCI6IFwiLi9zcmMvQXR0YWNoL0ltYWdlcy9ib2F0MTEuanBnXCIsXG5cdFwiLi9JbWFnZXMvYm9hdDIuanBnXCI6IFwiLi9zcmMvQXR0YWNoL0ltYWdlcy9ib2F0Mi5qcGdcIixcblx0XCIuL0ltYWdlcy9ib2F0My5qcGdcIjogXCIuL3NyYy9BdHRhY2gvSW1hZ2VzL2JvYXQzLmpwZ1wiLFxuXHRcIi4vSW1hZ2VzL2JvYXQ0LmpwZ1wiOiBcIi4vc3JjL0F0dGFjaC9JbWFnZXMvYm9hdDQuanBnXCIsXG5cdFwiLi9JbWFnZXMvYm9hdDUuanBnXCI6IFwiLi9zcmMvQXR0YWNoL0ltYWdlcy9ib2F0NS5qcGdcIixcblx0XCIuL0ltYWdlcy9ib2F0Ni5qcGdcIjogXCIuL3NyYy9BdHRhY2gvSW1hZ2VzL2JvYXQ2LmpwZ1wiLFxuXHRcIi4vSW1hZ2VzL2JvYXQ3LmpwZ1wiOiBcIi4vc3JjL0F0dGFjaC9JbWFnZXMvYm9hdDcuanBnXCIsXG5cdFwiLi9JbWFnZXMvYm9hdDguanBnXCI6IFwiLi9zcmMvQXR0YWNoL0ltYWdlcy9ib2F0OC5qcGdcIixcblx0XCIuL0ltYWdlcy9ib2F0OS5qcGdcIjogXCIuL3NyYy9BdHRhY2gvSW1hZ2VzL2JvYXQ5LmpwZ1wiLFxuXHRcIi4vSW1hZ2VzL2J1dHRvbi5qcGdcIjogXCIuL3NyYy9BdHRhY2gvSW1hZ2VzL2J1dHRvbi5qcGdcIixcblx0XCIuL0ltYWdlcy9kaXZpbmctaWNvbi5zdmdcIjogXCIuL3NyYy9BdHRhY2gvSW1hZ2VzL2RpdmluZy1pY29uLnN2Z1wiLFxuXHRcIi4vSW1hZ2VzL2Zpc2gtaWNvbi5zdmdcIjogXCIuL3NyYy9BdHRhY2gvSW1hZ2VzL2Zpc2gtaWNvbi5zdmdcIixcblx0XCIuL0ltYWdlcy9mb29kLWljb24uc3ZnXCI6IFwiLi9zcmMvQXR0YWNoL0ltYWdlcy9mb29kLWljb24uc3ZnXCIsXG5cdFwiLi9JbWFnZXMvaWNvbi1uYXYtbGlzdC5zdmdcIjogXCIuL3NyYy9BdHRhY2gvSW1hZ2VzL2ljb24tbmF2LWxpc3Quc3ZnXCIsXG5cdFwiLi9JbWFnZXMvaWNvbi1uYXYtbWFwLnN2Z1wiOiBcIi4vc3JjL0F0dGFjaC9JbWFnZXMvaWNvbi1uYXYtbWFwLnN2Z1wiLFxuXHRcIi4vSW1hZ2VzL2ljb24tbmF2LXNldHRpbmdzLnN2Z1wiOiBcIi4vc3JjL0F0dGFjaC9JbWFnZXMvaWNvbi1uYXYtc2V0dGluZ3Muc3ZnXCIsXG5cdFwiLi9JbWFnZXMvbG9nby1kYXJrLnN2Z1wiOiBcIi4vc3JjL0F0dGFjaC9JbWFnZXMvbG9nby1kYXJrLnN2Z1wiLFxuXHRcIi4vSW1hZ2VzL2xvZ28tbGlnaHQuc3ZnXCI6IFwiLi9zcmMvQXR0YWNoL0ltYWdlcy9sb2dvLWxpZ2h0LnN2Z1wiXG59O1xuXG5cbmZ1bmN0aW9uIHdlYnBhY2tDb250ZXh0KHJlcSkge1xuXHR2YXIgaWQgPSB3ZWJwYWNrQ29udGV4dFJlc29sdmUocmVxKTtcblx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oaWQpO1xufVxuZnVuY3Rpb24gd2VicGFja0NvbnRleHRSZXNvbHZlKHJlcSkge1xuXHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKG1hcCwgcmVxKSkge1xuXHRcdHZhciBlID0gbmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIiArIHJlcSArIFwiJ1wiKTtcblx0XHRlLmNvZGUgPSAnTU9EVUxFX05PVF9GT1VORCc7XG5cdFx0dGhyb3cgZTtcblx0fVxuXHRyZXR1cm4gbWFwW3JlcV07XG59XG53ZWJwYWNrQ29udGV4dC5rZXlzID0gZnVuY3Rpb24gd2VicGFja0NvbnRleHRLZXlzKCkge1xuXHRyZXR1cm4gT2JqZWN0LmtleXMobWFwKTtcbn07XG53ZWJwYWNrQ29udGV4dC5yZXNvbHZlID0gd2VicGFja0NvbnRleHRSZXNvbHZlO1xubW9kdWxlLmV4cG9ydHMgPSB3ZWJwYWNrQ29udGV4dDtcbndlYnBhY2tDb250ZXh0LmlkID0gXCIuL3NyYy9BdHRhY2ggc3luYyByZWN1cnNpdmUgXFxcXC5cIjsiLCIvLyQoZG9jdW1lbnQpLnJlYWR5KCgpID0+IHtcbi8vICAgY29uc3QgcHJlZiA9ICcuYnV0dG9uJzsgLy8gcHJlZml4IGZvciBjdXJyZW50IGZvbGRlclxuLy8gICBcbi8vICAgJChwcmVmKycnKVxuLy99KTsiLCIvLyQoZG9jdW1lbnQpLnJlYWR5KCgpID0+IHtcbi8vICAgY29uc3QgcHJlZiA9ICcuZGV2aWNlcic7IC8vIHByZWZpeCBmb3IgY3VycmVudCBmb2xkZXJcbi8vICAgXG4vLyAgICQocHJlZisnJylcbi8vfSk7IiwiLy8kKGRvY3VtZW50KS5yZWFkeSgoKSA9PiB7XG4vLyAgIGNvbnN0IHByZWYgPSAnLmlucHV0JzsgLy8gcHJlZml4IGZvciBjdXJyZW50IGZvbGRlclxuLy8gICBcbi8vICAgJChwcmVmKycnKVxuLy99KTsiLCIvLyQoZG9jdW1lbnQpLnJlYWR5KCgpID0+IHtcbi8vICAgY29uc3QgcHJlZiA9ICcubGluayc7IC8vIHByZWZpeCBmb3IgY3VycmVudCBmb2xkZXJcbi8vICAgXG4vLyAgICQocHJlZisnJylcbi8vfSk7IiwiLy8kKGRvY3VtZW50KS5yZWFkeSgoKSA9PiB7XG4vLyAgIGNvbnN0IHByZWYgPSAnLnBhbmVsLW1haW4nOyAvLyBwcmVmaXggZm9yIGN1cnJlbnQgZm9sZGVyXG4vLyAgIFxuLy8gICAkKHByZWYrJycpXG4vL30pOyIsIi8vJChkb2N1bWVudCkucmVhZHkoKCkgPT4ge1xuLy8gICBjb25zdCBwcmVmID0gJy5wYW5lbC1uYXZfX2J1dHRvbic7IC8vIHByZWZpeCBmb3IgY3VycmVudCBmb2xkZXJcbi8vICAgXG4vLyAgICQocHJlZisnJylcbi8vfSk7IiwiaW1wb3J0ICcuL19fYnV0dG9uL3BhbmVsLW5hdl9fYnV0dG9uJztcbi8vJChkb2N1bWVudCkucmVhZHkoKCkgPT4ge1xuLy8gICBjb25zdCBwcmVmID0gJy5wYW5lbC1uYXYnOyAvLyBwcmVmaXggZm9yIGN1cnJlbnQgZm9sZGVyXG4vLyAgIFxuLy8gICAkKHByZWYrJycpXG4vL30pOyIsInZhciBtYXAgPSB7XG5cdFwiLi9jb3JlLmpzXCI6IFwiLi9zcmMvTG9naWMvY29yZS5qc1wiXG59O1xuXG5cbmZ1bmN0aW9uIHdlYnBhY2tDb250ZXh0KHJlcSkge1xuXHR2YXIgaWQgPSB3ZWJwYWNrQ29udGV4dFJlc29sdmUocmVxKTtcblx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oaWQpO1xufVxuZnVuY3Rpb24gd2VicGFja0NvbnRleHRSZXNvbHZlKHJlcSkge1xuXHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKG1hcCwgcmVxKSkge1xuXHRcdHZhciBlID0gbmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIiArIHJlcSArIFwiJ1wiKTtcblx0XHRlLmNvZGUgPSAnTU9EVUxFX05PVF9GT1VORCc7XG5cdFx0dGhyb3cgZTtcblx0fVxuXHRyZXR1cm4gbWFwW3JlcV07XG59XG53ZWJwYWNrQ29udGV4dC5rZXlzID0gZnVuY3Rpb24gd2VicGFja0NvbnRleHRLZXlzKCkge1xuXHRyZXR1cm4gT2JqZWN0LmtleXMobWFwKTtcbn07XG53ZWJwYWNrQ29udGV4dC5yZXNvbHZlID0gd2VicGFja0NvbnRleHRSZXNvbHZlO1xubW9kdWxlLmV4cG9ydHMgPSB3ZWJwYWNrQ29udGV4dDtcbndlYnBhY2tDb250ZXh0LmlkID0gXCIuL3NyYy9Mb2dpYyBzeW5jIHJlY3Vyc2l2ZSBcXFxcLmpzJFwiOyIsImltcG9ydCAnLi8uLi8uLi9idW5kbGUnO1xuXG4vLyBDb2RlIGxpYnMgYW5kIHBsdWdpbnNcbmltcG9ydCB7IGdsb2JhbEV2ZW50b25lIH0gZnJvbSAnLi4vLi4vUGx1Z2lucy9ldmVudG9uZS5qcyc7XG5cbmdsb2JhbEV2ZW50b25lKCk7IiwiY29uc3QgX19FVkVOVE9ORV9fID0ge307XG5cbmZ1bmN0aW9uIGFjdGlvbihsYWJlbCwgaW5QbGFjZUNhbGxiYWNrKSB7XG4gIHJldHVybiBmdW5jdGlvbiAoLi4uYXJncykge1xuICAgIGxldCByZWFjdG9ycztcbiAgICBpZiAoX19FVkVOVE9ORV9fW2xhYmVsXSkgLy8gZ2l2aW5nIHNob3J0ZW4gbmFtZVxuICAgICAgcmVhY3RvcnMgPSBfX0VWRU5UT05FX19bbGFiZWxdO1xuXG4gICAgaWYgKHJlYWN0b3JzKSB7XG4gICAgICAvLyByZWFjdG9ycyBiZWZvcmUgbWFpbiByZWFjdG9yXG4gICAgICBpZiAoQXJyYXkuaXNBcnJheShyZWFjdG9ycy5iZWZvcmUpICYmIHJlYWN0b3JzLmJlZm9yZS5sZW5ndGggPiAwKVxuICAgICAgICByZWFjdG9ycy5iZWZvcmUuZm9yRWFjaCgoWywgcmVhY3Rvcl0pID0+IHJlYWN0b3IoLi4uYXJncykpO1xuICAgICAgLy8gbWFpbiByZWFjdG9yIHdpdGggMCBjYWxsUGxhY2VcbiAgICAgIGlmIChpblBsYWNlQ2FsbGJhY2spXG4gICAgICAgIGluUGxhY2VDYWxsYmFjayguLi5hcmdzKTtcbiAgICAgIC8vIHJlYWN0b3JzIGFmdGVyIG1haW4gcmVhY3RvclxuICAgICAgaWYgKEFycmF5LmlzQXJyYXkocmVhY3RvcnMuYWZ0ZXIpICYmIHJlYWN0b3JzLmFmdGVyLmxlbmd0aCA+IDApXG4gICAgICAgIHJlYWN0b3JzLmFmdGVyLmZvckVhY2goKFssIHJlYWN0b3JdKSA9PiByZWFjdG9yKC4uLmFyZ3MpKTtcblxuICAgIH0gZWxzZSBpZiAoaW5QbGFjZUNhbGxiYWNrKSB7XG4gICAgICBpblBsYWNlQ2FsbGJhY2soLi4uYXJncyk7IC8vanVzdCBtYWluIHJlYWN0b3IgY2FsbFxuICAgIH1cbiAgfTtcbn1cblxuZnVuY3Rpb24gd2hlbihhY3Rpb25MYWJlbCwgcmVhY3RvciwgY2FsbFBsYWNlID0gMCkge1xuICBpZiAodHlwZW9mIGFjdGlvbkxhYmVsID09ICdzdHJpbmcnKSB7XG4gICAgd2hlbkxvZ2ljKGFjdGlvbkxhYmVsKTtcbiAgfSBlbHNlIGlmIChBcnJheS5pc0FycmF5KGFjdGlvbkxhYmVsKSkge1xuICAgIGZvciAobGV0IHNpbmdsZUFjdGlvbkxhYmVsIG9mIGFjdGlvbkxhYmVsKSB7XG4gICAgICB3aGVuTG9naWMoc2luZ2xlQWN0aW9uTGFiZWwpO1xuICAgIH1cbiAgfVxuXG4gIGZ1bmN0aW9uIHdoZW5Mb2dpYyhhY3Rpb25MYWJlbCkge1xuICAgIGxldCBwbGFjZURpbWVuc2lvbiA9IGNhbGxQbGFjZSA8IDAgPyAnYmVmb3JlJyA6ICdhZnRlcic7XG4gICAgaWYgKCFfX0VWRU5UT05FX19bYWN0aW9uTGFiZWxdKSAvLyBjaGVjayBhY3Rpb25MYWJlbCBleGlzdFxuICAgICAgX19FVkVOVE9ORV9fW2FjdGlvbkxhYmVsXSA9IHt9OyAvLyBjcmVhdGUgaWYgbm90XG4gICAgaWYgKCFBcnJheS5pc0FycmF5KF9fRVZFTlRPTkVfX1thY3Rpb25MYWJlbF1bcGxhY2VEaW1lbnNpb25dKSkgLy8gY2hlY2sgZGltZW5zaW9uIGlzIEFycmF5XG4gICAgICBfX0VWRU5UT05FX19bYWN0aW9uTGFiZWxdW3BsYWNlRGltZW5zaW9uXSA9IFtdOyAvLyBjcmVhdGUgaWYgbm90XG5cbiAgICBfX0VWRU5UT05FX19bYWN0aW9uTGFiZWxdW3BsYWNlRGltZW5zaW9uXS5wdXNoKFtjYWxsUGxhY2UsIHJlYWN0b3JdKTsgLy8gcHVzaGluZyByZWFjdG9yIGluc2lkZVxuICAgIF9fRVZFTlRPTkVfX1thY3Rpb25MYWJlbF1bcGxhY2VEaW1lbnNpb25dLnNvcnQoKGEsIGIpID0+IGFbMF0gLSBiWzBdKTsgLy8gc29ydGluZyByZWFjdG9ycyBieSBjYWxsUGxhY2VcbiAgfVxufVxuXG5leHBvcnQgZnVuY3Rpb24gZ2xvYmFsRXZlbnRvbmUoKSB7XG4gIHdpbmRvdy5fX0VWRU5UT05FX18gPSBfX0VWRU5UT05FX187XG4gIHdpbmRvdy5hY3Rpb24gPSBhY3Rpb247XG4gIHdpbmRvdy53aGVuID0gd2hlbjtcbn0iLCJjb25zdCBpbXBvcnRlciA9IHJlcXVpcmUoJy4uL2Vudi93ZWJwYWNrLmltcG9ydGVyJyk7XHJcblxyXG5jb25zdCBpbXBvcnRlZCA9IGltcG9ydGVyKFtcclxuICByZXF1aXJlLmNvbnRleHQoJy4vTG9naWMvJywgdHJ1ZSwgL1xcLmpzJC8pLFxyXG4gIHJlcXVpcmUuY29udGV4dCgnLi9BdHRhY2gvJywgdHJ1ZSwgL1xcLi8pLFxyXG5dKTtcclxuXHJcbmltcG9ydCAnLi9CYXNpYy9kZXZpY2VyL2RldmljZXInO1xyXG5pbXBvcnQgJy4vQmFzaWMvaW5wdXQvaW5wdXQnO1xyXG5pbXBvcnQgJy4vQmFzaWMvYnV0dG9uL2J1dHRvbic7XHJcbmltcG9ydCAnLi9CYXNpYy9saW5rL2xpbmsnO1xyXG5pbXBvcnQgJy4vQmxvY2tzL3BhbmVsLW1haW4vcGFuZWwtbWFpbic7XHJcbmltcG9ydCAnLi9CbG9ja3MvcGFuZWwtbmF2L3BhbmVsLW5hdic7XHJcbiIsIi8vIFRoZSBtb2R1bGUgY2FjaGVcbnZhciBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX18gPSB7fTtcblxuLy8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbmZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG5cdGlmKF9fd2VicGFja19tb2R1bGVfY2FjaGVfX1ttb2R1bGVJZF0pIHtcblx0XHRyZXR1cm4gX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fW21vZHVsZUlkXS5leHBvcnRzO1xuXHR9XG5cdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG5cdHZhciBtb2R1bGUgPSBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX19bbW9kdWxlSWRdID0ge1xuXHRcdC8vIG5vIG1vZHVsZS5pZCBuZWVkZWRcblx0XHQvLyBubyBtb2R1bGUubG9hZGVkIG5lZWRlZFxuXHRcdGV4cG9ydHM6IHt9XG5cdH07XG5cblx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG5cdF9fd2VicGFja19tb2R1bGVzX19bbW9kdWxlSWRdKG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG5cdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG5cdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbn1cblxuIiwiLy8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbl9fd2VicGFja19yZXF1aXJlX18ubiA9IChtb2R1bGUpID0+IHtcblx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG5cdFx0KCkgPT4gbW9kdWxlWydkZWZhdWx0J10gOlxuXHRcdCgpID0+IG1vZHVsZTtcblx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgeyBhOiBnZXR0ZXIgfSk7XG5cdHJldHVybiBnZXR0ZXI7XG59OyIsIi8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb25zIGZvciBoYXJtb255IGV4cG9ydHNcbl9fd2VicGFja19yZXF1aXJlX18uZCA9IChleHBvcnRzLCBkZWZpbml0aW9uKSA9PiB7XG5cdGZvcih2YXIga2V5IGluIGRlZmluaXRpb24pIHtcblx0XHRpZihfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZGVmaW5pdGlvbiwga2V5KSAmJiAhX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIGtleSkpIHtcblx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBrZXksIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBkZWZpbml0aW9uW2tleV0gfSk7XG5cdFx0fVxuXHR9XG59OyIsIl9fd2VicGFja19yZXF1aXJlX18ubyA9IChvYmosIHByb3ApID0+IE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmosIHByb3ApIiwiLy8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuX193ZWJwYWNrX3JlcXVpcmVfXy5yID0gKGV4cG9ydHMpID0+IHtcblx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG5cdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG5cdH1cblx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbn07IiwiLy8gc3RhcnR1cFxuLy8gTG9hZCBlbnRyeSBtb2R1bGVcbl9fd2VicGFja19yZXF1aXJlX18oXCIuL3NyYy9QYWdlcy9pbmRleC9pbmRleC5qc1wiKTtcbi8vIFRoaXMgZW50cnkgbW9kdWxlIHVzZWQgJ2V4cG9ydHMnIHNvIGl0IGNhbid0IGJlIGlubGluZWRcbl9fd2VicGFja19yZXF1aXJlX18oXCIuL3NyYy9QYWdlcy9pbmRleC9pbmRleC5zYXNzXCIpO1xuIl0sInNvdXJjZVJvb3QiOiIifQ==