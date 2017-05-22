import React, { Component } from 'react'
import { render } from 'react-dom'
import { arrayMove } from 'react-sortable-hoc'
import axios from 'axios'

import { QuestionBuilderItem, SortableList } from './SortableBlocks'
import Header from './Header'
import InformationForm from './InformationForm'
import ClassSelect from './ClassSelect'

class CreateQuiz extends Component {
	constructor(props) {
		super(props)

		this.state = {
			current_step: 0,
			course_id: null,
			level: null,
			name: '',
			questions: [{id: 1, type: 1, answers: [], question: '', hint: ''}]
		}

		if (window.quiz_id) (
			this.getQuiz(window.quiz_id)
		)

		this.onSortEnd = this.onSortEnd.bind(this)
		this.updateQuestion = this.updateQuestion.bind(this)
		this.addQuestion = this.addQuestion.bind(this)
		this.setStep = this.setStep.bind(this)
		this.setCourse = this.setCourse.bind(this)
		this.setLevel = this.setLevel.bind(this)
		this.setName = this.setName.bind(this)
		this.saveQuiz = this.saveQuiz.bind(this)
	}

	getQuiz(id) {
		axios.get('/api/quiz/getSingle/' + id).then(response => {
			const questions = response.data.questions.map(question => {
				question.answers = question.answers.map(answer => {
					answer.correct = parseInt(answer.correct)

					return answer
				})

				return question
			})

			this.setState({
				course_id: parseInt(response.data.course_id),
				level: parseInt(response.data.level),
				name: response.data.title,
				questions: questions
			})
		})
	}

	updateQuestion(question) {
		let questions = this.state.questions
		const index = questions.find(q => q.id == question.id)
		
		questions[index] = question

		this.setState({ questions })
	}

	onSortEnd({ oldId, newId }) {
		const oldIndex = this.state.questions.find(q => q.id == oldId)
		const newIndex = this.state.questions.find(q => q.id == newId)
		
		this.setState({
			questions: arrayMove(this.state.questions, oldIndex, newIndex),
		})
	}

	addQuestion(position, question) {
		let questions = this.state.questions
		question.id = questions.sort((a, b) => b.id - a.id)[0].id + 1
		questions.splice(position, 0, question)

		this.setState({
			questions: questions
		})
	}

	setStep(index) {
		this.setState({
			current_step: index
		})
	}

	setCourse(id) {
		this.setState({
			course_id: id
		})
	}

	setLevel(level) {
		this.setState({ level })
	}

	setName(name) {
		this.setState({ name })
	}

	saveQuiz() {
		const { level, course_id, name, questions } = this.state

		if (level === null || name.length == 0) {
			alert('Navn og niveau skal angives i step 2')
			return
		}

		if (course_id === null) {
			alert('Fag skal angives i step 3')
			return
		}

		let questions_modified = questions.map(question => {
			question.answers = question.answers.map(answer => {
				answer.correct = answer.correct ? 1 : 0

				return answer
			})

			return question
		})

		const data = {
			title: name,
			course_id: parseInt(course_id),
			level: level,
			questions: questions_modified
		}

		if (window.quiz_id) {
			axios.post('/api/quiz/updatequiz/' + window.quiz_id, data).then(response => {
				alert('gemt!');
			}, response => {
				console.log(response)
			})
		}else {
			axios.post('/api/quiz/createquiz', data).then(response => {
				alert('gemt!');
			}, response => {
				console.log(response)
			})
		}
	}

	render() {
		const steps = [{value: '1'}, {value: '2'}, {value: '3'}]
		let view;

		if (this.state.current_step == 0) {
			view = (<SortableList helperClass="question-builder--dragging" 
							  lockAxis="y"
							  distance={20}
							  lockToContainerEdges={true}
							  useDragHandle={true}
							  addQuestion={this.addQuestion}
							  updateQuestion={this.updateQuestion} 
							  questions={this.state.questions} 
							  onSortEnd={this.onSortEnd} />)
		}else if (this.state.current_step == 1) {
			view = <InformationForm level={this.state.level} name={this.state.name} setLevel={this.setLevel} setName={this.setName} />
		}else if (this.state.current_step == 2) {
			view = <ClassSelect selectedCourse={this.state.course_id} setCourse={this.setCourse} />
		}

		return (
			<div>
				<Header steps={steps} active={this.state.current_step} setStep={this.setStep} onSave={this.saveQuiz} />

				{view}
			</div>
		)
	}
}

render(<CreateQuiz />, document.getElementById('create-quiz'));
