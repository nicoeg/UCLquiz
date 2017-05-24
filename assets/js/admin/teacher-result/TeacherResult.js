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
			questionsLength: null
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
		})
	}

	render() {
		let content

		if (this.state.class) {
			content = <StudentList />
		}else {
			content = <ClassSelect onClassSelected={this.onClassSelected} />
		}

		return (
			<div className="preview-container">
				<Sidebar handleChooseClass={() => this.onClassSelected(null)} />

				<div className="content">
					{content}
				</div>
			</div>
		)
	}
}

ReactDOM.render(<TeacherResult />, document.getElementById('teacherresult'));
