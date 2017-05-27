import React from 'react'
import { SortableContainer, SortableElement } from 'react-sortable-hoc'
import CSSTransitionGroup from 'react-transition-group/CSSTransitionGroup'
import QuestionBuilder from './QuestionBuilder'

export const QuestionBuilderItem = SortableElement(({ position, question, updateQuestion, addQuestion }) => 
	<QuestionBuilder position={position} question={question} updateQuestion={updateQuestion} addQuestion={addQuestion} />
)

export const SortableList = SortableContainer(({ questions, updateQuestion, addQuestion }) => {
	questions = questions.map((question, index) => (
		<QuestionBuilderItem key={`item-${question.id}`} index={parseInt(question.id)} position={index} addQuestion={addQuestion} updateQuestion={updateQuestion} question={question} />
	))

	return (
		<div className="quiz-container quiz-container--big quiz-container--horizontal">
			<CSSTransitionGroup
				style={{ width: '100%' }}
				transitionName="scale"
				transitionEnterTimeout={300}
				transitionLeaveTimeout={300}>
				{questions}
			</CSSTransitionGroup>
		</div>
	);
});
