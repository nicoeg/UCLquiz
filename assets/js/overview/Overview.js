import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'

import Sidebar from './Sidebar'
import QuizCard from './QuizCard'

class Overview extends Component {
	constructor() {
		super()

		this.state = {
			filter: null,
			courses: [],
			quizzes: []
		}

		this.getCourses()

		this.setFilter = this.setFilter.bind(this)
	}

	getCourses() {
		axios.get('api/quiz/getCourses')
			.then(response => {
				this.setState({courses: response.data}, this.getQuizzes)
			})
	}

	getQuizzes() {
		let endpoint = 'api/quiz/getQuizzes'

		if (this.state.filter == 'completed') {
			endpoint = 'api/quiz/getCompletedQuizzes'
		}else if (!isNaN(parseFloat(this.state.filter)) && isFinite(this.state.filter)) {
			endpoint = 'api/quiz/getQuizzesByCourse/' + this.state.filter
		}

		axios.get(endpoint)
			.then(response => this.setState({quizzes: response.data}))
	}

	setFilter(filter) {
		this.setState({ filter }, this.getQuizzes)
	}

	render() {
		const quizzes = this.state.quizzes.map((quiz, index) => (
			<QuizCard key={quiz.id + index} quiz={quiz} course={this.state.courses.find(c => c.id == quiz.course_id)} />
		))

		return (
			<div className="preview-container">
				<Sidebar courses={this.state.courses} currentFilter={this.state.filter} setFilter={this.setFilter} />

				<div className="content">
					{quizzes}
				</div>
			</div>
		)
	}
}

ReactDOM.render(<Overview />, document.getElementById('overview'));

