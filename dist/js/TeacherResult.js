webpackJsonp([3],{

/***/ 196:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_react_dom__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_axios__ = __webpack_require__(23);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__ResultSidebar__ = __webpack_require__(226);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__StudentList__ = __webpack_require__(227);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__ClassSelect__ = __webpack_require__(225);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }









var TeacherResult = function (_Component) {
	_inherits(TeacherResult, _Component);

	function TeacherResult() {
		_classCallCheck(this, TeacherResult);

		var _this = _possibleConstructorReturn(this, (TeacherResult.__proto__ || Object.getPrototypeOf(TeacherResult)).call(this));

		_this.state = {
			class: null,
			students: [],
			questionsLength: null,
			averageTime: null,
			averageAnswerRate: null,
			bestTime: null
		};

		__WEBPACK_IMPORTED_MODULE_2_axios___default.a.get('/api/quiz/getSingle/' + window.quiz_id).then(function (response) {
			_this.setState({ questionsLength: response.data.questions.length });
		});

		_this.onClassSelected = _this.onClassSelected.bind(_this);
		return _this;
	}

	_createClass(TeacherResult, [{
		key: 'onClassSelected',
		value: function onClassSelected(class_id) {
			this.setState({
				class: class_id
			}, class_id !== null ? this.getResults : null);
		}
	}, {
		key: 'getResults',
		value: function getResults() {
			var _this2 = this;

			var data = { class_id: this.state.class, quiz_id: window.quiz_id };

			__WEBPACK_IMPORTED_MODULE_2_axios___default.a.post('/api/result/getclassresults', data).then(function (response) {
				_this2.setState({ students: response.data });

				_this2.calculate(response.data);
			});
		}
	}, {
		key: 'calculate',
		value: function calculate(data) {
			this.setState({
				averageTime: this.formatTime(data.reduce(function (a, b) {
					return a + parseInt(b.time_seconds);
				}, 0) / data.length),
				averageAnswerRate: Math.round(data.reduce(function (a, b) {
					return a + parseInt(b.correct_answers_count);
				}, 0) / data.length * 10) / 10,
				bestTime: this.formatTime(data.sort(function (a, b) {
					return a.time_seconds > b.time_seconds;
				})[0].time_seconds)
			});
		}
	}, {
		key: 'formatTime',
		value: function formatTime(seconds) {
			var minutes = Math.floor(seconds / 60);
			seconds = Math.round(seconds % 60);

			return minutes + 'm ' + seconds + 's';
		}
	}, {
		key: 'render',
		value: function render() {
			var _this3 = this;

			var _state = this.state,
			    students = _state.students,
			    averageTime = _state.averageTime,
			    averageAnswerRate = _state.averageAnswerRate,
			    questionsLength = _state.questionsLength,
			    bestTime = _state.bestTime;

			var content = void 0;

			if (this.state.class) {
				content = __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_4__StudentList__["a" /* default */], { students: this.state.students });
			} else {
				content = __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_5__ClassSelect__["a" /* default */], { onClassSelected: this.onClassSelected });
			}

			return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
				'div',
				{ className: 'preview-container' },
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_3__ResultSidebar__["a" /* default */], { averageTime: averageTime, averageAnswerRate: averageAnswerRate, bestTime: bestTime, questionsLength: questionsLength, handleChooseClass: function handleChooseClass() {
						return _this3.onClassSelected(null);
					} }),
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'div',
					{ className: 'content' },
					content
				)
			);
		}
	}]);

	return TeacherResult;
}(__WEBPACK_IMPORTED_MODULE_0_react__["Component"]);

__WEBPACK_IMPORTED_MODULE_1_react_dom___default.a.render(__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(TeacherResult, null), document.getElementById('teacherresult'));

/***/ }),

/***/ 225:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios__ = __webpack_require__(23);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_axios__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var ClassSelect = function (_Component) {
	_inherits(ClassSelect, _Component);

	function ClassSelect(props) {
		_classCallCheck(this, ClassSelect);

		var _this = _possibleConstructorReturn(this, (ClassSelect.__proto__ || Object.getPrototypeOf(ClassSelect)).call(this, props));

		_this.state = {
			classes: []
		};

		__WEBPACK_IMPORTED_MODULE_1_axios___default.a.get('/api/result/getclasslist/' + window.quiz_id).then(function (response) {
			return _this.setState({ classes: response.data });
		});
		return _this;
	}

	_createClass(ClassSelect, [{
		key: 'render',
		value: function render() {
			var _this2 = this;

			var classes = this.state.classes.map(function (classRecord) {
				return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'tr',
					{ key: classRecord.id, className: 'table__item' },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'td',
						{ className: 'table__column' },
						classRecord.name
					),
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'td',
						{ className: 'table__column' },
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							'span',
							{ className: 'button button--primary button--small', onClick: function onClick() {
									return _this2.props.onClassSelected(classRecord.id);
								} },
							'V\xE6lg'
						)
					)
				);
			});

			return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
				'table',
				{ className: 'table' },
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'thead',
					{ className: 'table__header' },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'tr',
						{ className: 'table__item' },
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							'td',
							{ className: 'table__column' },
							'Klasse'
						),
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							'td',
							{ className: 'table__column' },
							'Handling'
						)
					)
				),
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'tbody',
					{ className: 'table__body' },
					classes
				)
			);
		}
	}]);

	return ClassSelect;
}(__WEBPACK_IMPORTED_MODULE_0_react__["Component"]);

/* harmony default export */ __webpack_exports__["a"] = (ClassSelect);

/***/ }),

/***/ 226:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(3);
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

		_this.handleChooseClass = _this.handleChooseClass.bind(_this);
		return _this;
	}

	_createClass(Sidebar, [{
		key: 'handleChooseClass',
		value: function handleChooseClass() {
			this.props.handleChooseClass();
		}
	}, {
		key: 'percent',
		value: function percent() {
			return this.props.averageAnswerRate ? this.props.questionsLength / this.props.averageAnswerRate * 10 : 100;
		}
	}, {
		key: 'render',
		value: function render() {
			return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
				'div',
				{ className: 'sidebar', style: { marginTop: '5px' } },
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'div',
					{ className: 'sidebar__buttons' },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'a',
						{ href: window.settings.baseUrl + 'teacher', style: { textDecoration: 'none' }, className: 'button button--primary' },
						'Tilbage'
					),
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'span',
						{ className: 'button button--primary', onClick: this.handleChooseClass },
						'V\xE6lg klasse'
					)
				),
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'div',
					{ className: 'sidebar__block' },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'h1',
						{ className: 'sidebar__heading' },
						'Gennemsnits svarrate'
					),
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'div',
						{ className: 'donut-chart', style: { transform: 'scale(.8)', animationDelay: '-' + this.percent() + 's' } },
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							'span',
							null,
							this.props.averageAnswerRate,
							' ud af ',
							this.props.questionsLength,
							' rigtige'
						)
					)
				),
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'div',
					{ className: 'sidebar__block' },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'h1',
						{ className: 'sidebar__heading' },
						'Gennemsnits tid'
					),
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'h1',
						{ className: 'sidebar__heading sidebar__heading--primary' },
						this.props.averageTime
					)
				),
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					'div',
					{ className: 'sidebar__block' },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'h1',
						{ className: 'sidebar__heading' },
						'Bedste tid'
					),
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						'h1',
						{ className: 'sidebar__heading sidebar__heading--primary' },
						this.props.bestTime
					)
				)
			);
		}
	}]);

	return Sidebar;
}(__WEBPACK_IMPORTED_MODULE_0_react__["Component"]);

/* harmony default export */ __webpack_exports__["a"] = (Sidebar);

/***/ }),

/***/ 227:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var StudentList = function (_Component) {
	_inherits(StudentList, _Component);

	function StudentList(props) {
		_classCallCheck(this, StudentList);

		return _possibleConstructorReturn(this, (StudentList.__proto__ || Object.getPrototypeOf(StudentList)).call(this, props));
	}

	_createClass(StudentList, [{
		key: "formatTime",
		value: function formatTime(seconds) {
			var minutes = Math.floor(seconds / 60);
			seconds = Math.round(seconds % 60);

			return minutes + "m " + seconds + "s";
		}
	}, {
		key: "render",
		value: function render() {
			var _this2 = this;

			var students = this.props.students.map(function (student, index) {
				return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					"tr",
					{ key: index, className: "table__item" },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						"td",
						{ className: "table__column" },
						index + 1
					),
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						"td",
						{ className: "table__column" },
						student.name
					),
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						"td",
						{ className: "table__column" },
						_this2.formatTime(student.time_seconds)
					),
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						"td",
						{ className: "table__column" },
						student.correct_answers_count
					),
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						"td",
						{ className: "table__column" },
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							"a",
							{ style: { textDecoration: 'none' }, href: '/teacher/userresults/' + student.user_quiz_id, className: "button button--primary button--small" },
							"V\xE6lg"
						)
					)
				);
			});

			return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
				"table",
				{ className: "table" },
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					"thead",
					{ className: "table__header" },
					__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
						"tr",
						{ className: "table__item" },
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							"td",
							{ className: "table__column" },
							"Plads"
						),
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							"td",
							{ className: "table__column" },
							"Navn"
						),
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							"td",
							{ className: "table__column" },
							"Tid"
						),
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							"td",
							{ className: "table__column" },
							"Antal rigtige"
						),
						__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
							"td",
							{ className: "table__column" },
							"Handling"
						)
					)
				),
				__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
					"tbody",
					{ className: "table__body" },
					students
				)
			);
		}
	}]);

	return StudentList;
}(__WEBPACK_IMPORTED_MODULE_0_react__["Component"]);

/* harmony default export */ __webpack_exports__["a"] = (StudentList);

/***/ }),

/***/ 494:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(196);


/***/ })

},[494]);