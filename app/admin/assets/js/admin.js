/******/
(() => { // webpackBootstrap
    /******/
    var __webpack_modules__ = ({

        /***/ "./js/src/app.js":
        /*!***********************!*\
          !*** ./js/src/app.js ***!
          \***********************/
        /***/ (() => {

            +function ($) {
                "use strict";

                $("#side-nav-menu").metisMenu({
                    toggle: true,
                    collapseInClass: 'show'
                });
                $("#navSidebar").on('show.bs.collapse', function () {
                    $('.sidebar').addClass('show');
                }).on('hide.bs.collapse', function () {
                    $('.sidebar').removeClass('show');
                });
                $(document).render(function () {
                    $('a, span, button', document).tooltip({
                        placement: 'bottom'
                    });
                    $.fn.select2.defaults.set('width', null);
                    $.fn.select2.defaults.set('theme', 'bootstrap');
                    $.fn.select2.defaults.set('minimumResultsForSearch', 10);
                    $('select.form-control', document).select2();
                    $('.alert', document).alert();
                }); // Multiple Modal Fix

                $(document).on('show.bs.modal', '.modal', function () {
                    var zIndex = 1040+(10 * $('.modal:visible').length+1);
                    $(this).css('z-index', zIndex);
                    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex-2).addClass('modal-stack');
                    setTimeout(function () {
                        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex-1).addClass('modal-stack');
                    }, 0);
                });
                $(document).on('hidden.bs.modal', '.modal', function () {
                    $('.modal:visible').length && $(document.body).addClass('modal-open');
                }); // Varying modal content

                $(document).on('show.bs.modal', '.modal', function (event) {
                    var $modal = $(this),
                        $button = $(event.relatedTarget);
                    if (!$button.length) return;
                    $.each($button.get(0).attributes, function (index, attribute) {
                        if (/^data-modal-/.test(attribute.name)) {
                            var attrName = attribute.name.substr(11),
                                attrValue = attribute.value;
                            $modal.find('[data-modal-html="'+attrName+'"]').html(attrValue);
                            $modal.find('[data-modal-text="'+attrName+'"]').text(attrValue);
                            $modal.find('[data-modal-input="'+attrName+'"]').val(attrValue);
                        }
                    });
                });
                $(window).on('ajaxErrorMessage', function (event, message) {
                    if (!message) return;
                    $.ti.flashMessage({
                        "class": 'danger',
                        text: message,
                        allowDismiss: false
                    });
                    event.preventDefault();
                });
                /*
                 * Ensure the CSRF token is added to all AJAX requests.
                 */

                $.ajaxPrefilter(function (options) {
                    var token = $('meta[name="csrf-token"]').attr('content');

                    if (token) {
                        if (!options.headers) options.headers = {};
                        options.headers['X-CSRF-TOKEN'] = token;
                    }
                });
            }(window.jQuery);

            /***/
        }),

        /***/ "./css/src/app.css":
        /*!*************************!*\
          !*** ./css/src/app.css ***!
          \*************************/
        /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

            "use strict";
            __webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


            /***/
        })

        /******/
    });
    /************************************************************************/
    /******/ 	// The module cache
    /******/
    var __webpack_module_cache__ = {};
    /******/
    /******/ 	// The require function
    /******/
    function __webpack_require__(moduleId) {
        /******/ 		// Check if module is in cache
        /******/
        var cachedModule = __webpack_module_cache__[moduleId];
        /******/
        if (cachedModule !== undefined) {
            /******/
            return cachedModule.exports;
            /******/
        }
        /******/ 		// Create a new module (and put it into the cache)
        /******/
        var module = __webpack_module_cache__[moduleId] = {
            /******/ 			// no module.id needed
            /******/ 			// no module.loaded needed
            /******/            exports: {}
            /******/
        };
        /******/
        /******/ 		// Execute the module function
        /******/
        __webpack_modules__[moduleId](module, module.exports, __webpack_require__);
        /******/
        /******/ 		// Return the exports of the module
        /******/
        return module.exports;
        /******/
    }

    /******/
    /******/ 	// expose the modules object (__webpack_modules__)
    /******/
    __webpack_require__.m = __webpack_modules__;
    /******/
    /************************************************************************/
    /******/ 	/* webpack/runtime/chunk loaded */
    /******/
    (() => {
        /******/
        var deferred = [];
        /******/
        __webpack_require__.O = (result, chunkIds, fn, priority) => {
            /******/
            if (chunkIds) {
                /******/
                priority = priority || 0;
                /******/
                for (var i = deferred.length; i > 0 && deferred[i-1][2] > priority; i--) deferred[i] = deferred[i-1];
                /******/
                deferred[i] = [chunkIds, fn, priority];
                /******/
                return;
                /******/
            }
            /******/
            var notFulfilled = Infinity;
            /******/
            for (var i = 0; i < deferred.length; i++) {
                /******/
                var [chunkIds, fn, priority] = deferred[i];
                /******/
                var fulfilled = true;
                /******/
                for (var j = 0; j < chunkIds.length; j++) {
                    /******/
                    if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
                        /******/
                        chunkIds.splice(j--, 1);
                        /******/
                    } else {
                        /******/
                        fulfilled = false;
                        /******/
                        if (priority < notFulfilled) notFulfilled = priority;
                        /******/
                    }
                    /******/
                }
                /******/
                if (fulfilled) {
                    /******/
                    deferred.splice(i--, 1)
                    /******/
                    var r = fn();
                    /******/
                    if (r !== undefined) result = r;
                    /******/
                }
                /******/
            }
            /******/
            return result;
            /******/
        };
        /******/
    })();
    /******/
    /******/ 	/* webpack/runtime/hasOwnProperty shorthand */
    /******/
    (() => {
        /******/
        __webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
        /******/
    })();
    /******/
    /******/ 	/* webpack/runtime/make namespace object */
    /******/
    (() => {
        /******/ 		// define __esModule on exports
        /******/
        __webpack_require__.r = (exports) => {
            /******/
            if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
                /******/
                Object.defineProperty(exports, Symbol.toStringTag, {value: 'Module'});
                /******/
            }
            /******/
            Object.defineProperty(exports, '__esModule', {value: true});
            /******/
        };
        /******/
    })();
    /******/
    /******/ 	/* webpack/runtime/jsonp chunk loading */
    /******/
    (() => {
        /******/ 		// no baseURI
        /******/
        /******/ 		// object to store loaded and loading chunks
        /******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
        /******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
        /******/
        var installedChunks = {
            /******/            "/js/admin": 0,
            /******/            "css/admin": 0
            /******/
        };
        /******/
        /******/ 		// no chunk on demand loading
        /******/
        /******/ 		// no prefetching
        /******/
        /******/ 		// no preloaded
        /******/
        /******/ 		// no HMR
        /******/
        /******/ 		// no HMR manifest
        /******/
        /******/
        __webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
        /******/
        /******/ 		// install a JSONP callback for chunk loading
        /******/
        var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
            /******/
            var [chunkIds, moreModules, runtime] = data;
            /******/ 			// add "moreModules" to the modules object,
            /******/ 			// then flag all "chunkIds" as loaded and fire callback
            /******/
            var moduleId, chunkId, i = 0;
            /******/
            if (chunkIds.some((id) => (installedChunks[id] !== 0))) {
                /******/
                for (moduleId in moreModules) {
                    /******/
                    if (__webpack_require__.o(moreModules, moduleId)) {
                        /******/
                        __webpack_require__.m[moduleId] = moreModules[moduleId];
                        /******/
                    }
                    /******/
                }
                /******/
                if (runtime) var result = runtime(__webpack_require__);
                /******/
            }
            /******/
            if (parentChunkLoadingFunction) parentChunkLoadingFunction(data);
            /******/
            for (; i < chunkIds.length; i++) {
                /******/
                chunkId = chunkIds[i];
                /******/
                if (__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
                    /******/
                    installedChunks[chunkId][0]();
                    /******/
                }
                /******/
                installedChunks[chunkIds[i]] = 0;
                /******/
            }
            /******/
            return __webpack_require__.O(result);
            /******/
        }
        /******/
        /******/
        var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
        /******/
        chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
        /******/
        chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
        /******/
    })();
    /******/
    /************************************************************************/
    /******/
    /******/ 	// startup
    /******/ 	// Load entry module and return exports
    /******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
    /******/
    __webpack_require__.O(undefined, ["css/admin"], () => (__webpack_require__("./js/src/app.js")))
    /******/
    var __webpack_exports__ = __webpack_require__.O(undefined, ["css/admin"], () => (__webpack_require__("./css/src/app.css")))
    /******/
    __webpack_exports__ = __webpack_require__.O(__webpack_exports__);
    /******/
    /******/
})()
;
