webpackJsonp([3],{

/***/ 196:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_react_dom__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_axios__ = __webpack_require__(26);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__Sidebar__ = __webpack_require__(226);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__QuizCard__ = __webpack_require__(225);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }








var Overview = function (_Component) {
	_inherits(Overview, _Component);

	function Overview() {
		_classCallCheck(this, Overview);

		var _this = _possibleConstructorReturn(this, (Overview.__proto__ || Object.getPrototypeOf(Overview)).call(this));

		_this.state = {
			filter: null,
			courses: [],
			quizzes: []
		};

		_this.getCourses();

		_this.setFilter = _this.setFilter.bind(_this);
		return _this;
	}

	_createClass(Overview, [{
		key: 'getCourses',
		value: function getCourses() {
			var _this2 = this;

			__WEBPACK_IMPORTED_MODULE_2_axios___default.a.get('api/quiz/getCourses').then(function (response) {
				_this2.setState({ courses: response.data }, _this2.getQuizzes);
			});
		}
	}, {
		key: 'getQuizzes',
		value: function getQuizzes() {
			var _this3 = this;

			var endpoint = 'api/quiz/getQuizzes';

			if (this.state.filter == 'completed') {
				endpoint = 'api/quiz/getCompletedQuizzes';
			} else if (!isNaN(parseFloat(this.state.filter)) && isFinite(this.state.filter)) {
				endpoint = 'api/quiz/getQuizzesByCourse/' + this.state.filter;
			}

			__WEBPACK_IMPORTED_MODULE_2_axios___default.a.get(endpoint).then(function (response) {
				return _this3.setState({ quizzes: response.data });
			});
		}
	}, {
		key: 'setFilter',
		value: function setFilter(filter) {
			this.setState({ filter: filter }, this.getQuizzes);
		}
	}, {
		key: 'render',
		value: function render() {
			var _this4 = this;

			var quizzes = this.state.quizzes.map(function (quiz, index) {
				return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_4__QuizCard__["a" /* default */], { key: quiz.id + index, quiz: quiz, course: _this4.state.courses.find(function (c) {
						return c.id == quiz.course_id;
					}) });
			});

			return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
				'div',
				{ className: 'preview-container' },
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_3__Sidebar__["a" /* default */], { courses: this.state.courses, currentFilter: this.state.filter, setFilter: this.setFilter }),
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'div',
					{ className: 'content' },
					quizzes
				)
			);
		}
	}]);

	return Overview;
}(__WEBPACK_IMPORTED_MODULE_0_react__["Component"]);

__WEBPACK_IMPORTED_MODULE_1_react_dom___default.a.render(__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(Overview, null), document.getElementById('overview'));

/***/ }),

/***/ 225:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var QuizCard = function (_Component) {
	_inherits(QuizCard, _Component);

	function QuizCard() {
		_classCallCheck(this, QuizCard);

		return _possibleConstructorReturn(this, (QuizCard.__proto__ || Object.getPrototypeOf(QuizCard)).apply(this, arguments));
	}

	_createClass(QuizCard, [{
		key: 'render',
		value: function render() {
			var levels = ['Let', 'Middel', 'Svær'];

			return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
				'a',
				{ href: window.settings.baseUrl + (window.role == 1 ? 'teacher/edit/' : 'student/quiz/') + this.props.quiz.id, className: 'card' },
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'div',
					{ className: 'card__image', style: { background: "url('" + this.props.course.image + "') 50% 50%/cover" } },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'div',
						{ className: 'card__labels' },
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							'div',
							{ className: 'card__label' },
							__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
								'p',
								null,
								levels[this.props.quiz.level - 1]
							)
						),
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							'div',
							{ className: 'card__label card__label--orange' },
							__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
								'p',
								null,
								this.props.course.name
							)
						)
					)
				),
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'div',
					{ className: 'card__title' },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'p',
						null,
						this.props.quiz.title
					)
				)
			);
		}
	}]);

	return QuizCard;
}(__WEBPACK_IMPORTED_MODULE_0_react__["Component"]);

/* harmony default export */ __webpack_exports__["a"] = (QuizCard);

/***/ }),

/***/ 226:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var Sidebar = function (_Component) {
	_inherits(Sidebar, _Component);

	function Sidebar(props) {
		_classCallCheck(this, Sidebar);

		var _this = _possibleConstructorReturn(this, (Sidebar.__proto__ || Object.getPrototypeOf(Sidebar)).call(this, props));

		_this.setFilter = _this.setFilter.bind(_this);
		return _this;
	}

	_createClass(Sidebar, [{
		key: 'setFilter',
		value: function setFilter(filter) {
			this.props.setFilter(filter);
		}
	}, {
		key: 'render',
		value: function render() {
			var _this2 = this;

			var courses = this.props.courses.map(function (course) {
				return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'li',
					{ className: 'sidebar__list-item', key: course.id, onClick: function onClick() {
							return _this2.setFilter(course.id);
						} },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'a',
						{ className: 'sidebar__link ' + (_this2.props.currentFilter == course.id ? 'sidebar__link--selected' : ''), href: '#' },
						course.name
					)
				);
			});

			return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
				'div',
				{ className: 'sidebar' },
				window.role == 1 ? __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'div',
					{ style: { marginBottom: '30px' } },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'a',
						{ style: { textDecoration: 'none' }, href: window.settings.baseUrl + 'teacher/create', className: 'button button--primary' },
						'Opret quiz'
					)
				) : '',
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'ul',
					{ className: 'sidebar__list' },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'li',
						{ className: 'sidebar__list-item', onClick: function onClick() {
								return _this2.setFilter(null);
							} },
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							'a',
							{ className: 'sidebar__link ' + (this.props.currentFilter == null ? 'sidebar__link--selected' : ''), href: '#' },
							'Nyeste quizzer'
						)
					),
					courses,
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'li',
						{ className: 'sidebar__list-item', onClick: function onClick() {
								return _this2.setFilter('completed');
							} },
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							'a',
							{ className: 'sidebar__link ' + (this.props.currentFilter == 'completed' ? 'sidebar__link--selected' : ''), href: '#' },
							'Gennemf\xF8rte quizzer'
						)
					)
				)
			);
		}
	}]);

	return Sidebar;
}(__WEBPACK_IMPORTED_MODULE_0_react__["Component"]);

/* harmony default export */ __webpack_exports__["a"] = (Sidebar);

/***/ }),

/***/ 491:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(196);


/***/ })

},[491]);