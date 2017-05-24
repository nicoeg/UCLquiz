import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'

import Sidebar from './ResultSidebar'
import StudentList from './StudentList'
import ClassSelect from './ClassSelect'

class TeacherResult extends Component {
	constructor() {
		super()

		this.state = {
			class: null,
			students: [],
			questionsLength: null,
			averageTime: null,
			averageAnswerRate: null,
			bestTime: null
		}

		axios.get('/api/quiz/getSingle/' + window.quiz_id).then(response => {
            this.setState({questionsLength: response.data.questions.length})
        })

		this.onClassSelected = this.onClassSelected.bind(this)
	}

	onClassSelected(class_id) {
		this.setState({ 
			class: class_id 
		}, class_id !== null ? this.getResults : null)
	}

	getResults() {
		const data = { class_id: this.state.class, quiz_id: window.quiz_id }

		axios.post('/api/result/getclassresults', data).then(response => {
			this.setState({ students: response.data })

			this.calculate(response.data)
		})
	}

	calculate(data) {
		this.setState({
			averageTime: this.formatTime(data.reduce((a, b) => a + parseInt(b.time_seconds), 0) / data.length),
			averageAnswerRate: Math.round(data.reduce((a, b) => a + parseInt(b.correct_answers_count), 0) / data.length * 10) / 10,
			bestTime: this.formatTime(data.sort((a, b) => a.time_seconds > b.time_seconds)[0].time_seconds)
		})
	}

	formatTime(seconds) {
        const minutes = Math.floor(seconds / 60)
        seconds = Math.round(seconds % 60)

        return `${minutes}m ${seconds}s`
    }

	render() {
		const { students, averageTime, averageAnswerRate, questionsLength, bestTime } = this.state
		let content

		if (this.state.class) {
			content = <StudentList students={this.state.students} />
		}else {
			content = <ClassSelect onClassSelected={this.onClassSelected} />
		}

		return (
			<div className="preview-container">
				<Sidebar averageTime={averageTime} averageAnswerRate={averageAnswerRate} bestTime={bestTime} questionsLength={questionsLength} handleChooseClass={() => this.onClassSelected(null)} />

				<div className="content">
					{content}
				</div>
			</div>
		)
	}
}

ReactDOM.render(<TeacherResult />, document.getElementById('teacherresult'));
