import React, { Component } from 'react'
import { render } from 'react-dom'
import { arrayMove } from 'react-sortable-hoc'

import { QuestionBuilderItem, SortableList } from './SortableBlocks'
import Header from './Header'
import ClassSelect from './ClassSelect'

class CreateQuiz extends Component {
	constructor(props) {
		super(props)

		this.state = {
			current_step: 0,
			course_id: null,
			questions: [{id: 1, type: 1, answers: [], question: 'Heyt'}, {id: 2, type: 1, answers: [], question: 'Hedasdasyt'}, {id: 3, type: 1, answers: [], question: 'Hedasdasyt'}]
		}

		this.onSortEnd = this.onSortEnd.bind(this)
		this.updateQuestion = this.updateQuestion.bind(this)
		this.addQuestion = this.addQuestion.bind(this)
		this.setStep = this.setStep.bind(this)
		this.setCourse = this.setCourse.bind(this)
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
			
		}else if (this.state.current_step == 2) {
			view = <ClassSelect setCourse={this.setCourse} />
		}

		return (
			<div>
				<Header steps={steps} active={this.state.current_step} setStep={this.setStep} />

				{view}
			</div>
		)
	}
}

render(<CreateQuiz />, document.getElementById('create-quiz'));
