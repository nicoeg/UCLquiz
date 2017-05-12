import React, { Component } from 'react'
import { SortableHandle } from 'react-sortable-hoc'

const blockName = 'multiple-choice-builder'

const DragHandle = SortableHandle(() => <span className={blockName + '__handle'}>::</span>)


export default class MultipleChoiceQuestionBuilder extends Component {
	constructor(props) {
		super(props)

		this.handleQuestionChange = this.handleQuestionChange.bind(this)
	}

	handleQuestionChange(event) {
		this.props.updateQuestion(
			Object.assign(this.props.question, {
				question: event.target.value,
				answers: this.props.question.answers
			})
		)
	}

	render() {
		return (
			<div className={blockName}>
				<div className={blockName + '__header'}>
					<button className="button button--small button--primary">Multiple choice</button>

					<DragHandle />
				</div>
				<div className={blockName + '__body'}>
					<input type="text" className="textfield" placeholder="Skriv spørgsmål her" value={this.props.question.question} onChange={this.handleQuestionChange} />

					<hr/>
				</div>
				{this.props.question.question}
			</div>
		)
	}
}
