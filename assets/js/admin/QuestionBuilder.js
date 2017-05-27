import React, { Component } from 'react'
import { SortableHandle } from 'react-sortable-hoc'

import AddQuestionBlock from './AddQuestionBlock'
import MultipleChoiceQuestionBuilder from './questionTypes/MultipleChoiceQuestionBuilder'

const blockName = 'question-builder'

const DragHandle = SortableHandle(() => <span className={blockName + '__handle'}>::</span>)

export default class QuestionBuilder extends Component {
	constructor(props) {
		super(props)

		this.handleQuestionChange = this.handleQuestionChange.bind(this) 
		this.handleHintChange = this.handleHintChange.bind(this) 
		this.updateAnswers = this.updateAnswers.bind(this)
	}

	handleQuestionChange(event) {
		this.props.updateQuestion(
			Object.assign(this.props.question, {
				question: event.target.value,
			})
		)
	}

	handleHintChange(event) {
		this.props.updateQuestion(
			Object.assign(this.props.question, {
				hint: event.target.value
			})
		)
	}

	updateAnswers(answers) {
		this.props.updateQuestion(
			Object.assign(this.props.question, {
				answers: answers
			})
		)
	}

	render() {
		const { position, question, updateQuestion, addQuestion } = this.props
	
		let questionType, questionTypeElement

		if (question.type == 1) {
			questionType = 'Multiple choice'
			questionTypeElement = <MultipleChoiceQuestionBuilder updateAnswers={this.updateAnswers} answers={question.answers}></MultipleChoiceQuestionBuilder>
		}

		return (
			<div className={blockName}>
				<AddQuestionBlock addQuestion={addQuestion} position={position}  />

				<div style={{ margin: '25px auto' }} className="main-container main-container--fill">
					<div className={blockName + '__container'}>
						<div className={blockName + '__header'}>
							<button className="button button--small button--primary">{questionType}</button>

							<DragHandle />
						</div>
						<div className={blockName + '__body'}>
							<input type="text" className="textfield" placeholder="Skriv spørgsmål her" value={this.props.question.question} onChange={this.handleQuestionChange} />

							<input type="text" className="textfield" placeholder="Hint" value={this.props.question.hint ? this.props.question.hint : ''} onChange={this.handleHintChange} />

							<hr/>
						</div>
					</div>

					<div className={blockName + '__answers'}>
						{questionTypeElement}
					</div>
				</div>
			</div>
		)
	}
}
