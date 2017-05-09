import React, { Component } from 'react'
import { render } from 'react-dom';
import { SortableContainer, SortableElement, arrayMove } from 'react-sortable-hoc';

import MultipleChoiceQuestionBuilder from './questionTypes/MultipleChoiceQuestionBuilder';

const SortableItem = SortableElement(({ question, updateQuestion }) => {
	let element

	if (question.type == 1) {
		element = <MultipleChoiceQuestionBuilder updateQuestion={updateQuestion} question={question}></MultipleChoiceQuestionBuilder>
	}

	return (
		<div className="main-container main-container--fill">
			{element}
		</div>
	)
});

const SortableList = SortableContainer(({ questions, updateQuestion }) => {
	return (
		<div className="quiz-container quiz-container--big quiz-container--horizontal">
			{questions.map((question, index) => (
				<SortableItem key={`item-${index}`} index={index} updateQuestion={updateQuestion} question={question} />
			))}
		</div>
	);
});

class CreateQuiz extends Component {
	constructor(props) {
		super(props)

		this.state = {
			questions: [{id: 1, type: 1, answers: [], question: 'Heyt'}]
		}

		this.onSortEnd = this.onSortEnd.bind(this)
		this.updateQuestion = this.updateQuestion.bind(this)
	}

	updateQuestion(question) {
		let questions = this.state.questions
		const index = questions.find(q => q.id == question.id)
		
		questions[index] = question

		this.setState({ questions })
	}

	onSortEnd({ oldIndex, newIndex }) {
		this.setState({
			questions: arrayMove(this.state.questions, oldIndex, newIndex),
		})
	}

	render() {
		return <SortableList updateQuestion={this.updateQuestion} questions={this.state.questions} onSortEnd={this.onSortEnd} />
	}
}

render(<CreateQuiz />, document.getElementById('create-quiz'));
