import React from 'react'

export default class MultipleChoiceQuestion extends React.Component {
    constructor(props) {
        super(props);

        this.state = { selectedAnswer: props.currentAnswer }

        this.selectAnswer = this.selectAnswer.bind(this)
    }

    selectAnswer(id) {
        if (this.props.readOnly) return

        this.setState({ selectedAnswer: id })

        this.props.selectAnswer(id)
    }

    render() {
        const answers = this.props.answers.map(answer => {
            return (
                <li key={answer.id}
                    onClick={() => this.selectAnswer(answer.id)}
                    className={"answer " + (answer.id == this.state.selectedAnswer ? 'selected' : '')}>
                    {answer.answer}
                </li>
            )
        })

        return (
            <div className="answers multiplechoice">
                <ol>
                    {answers}
                </ol>
            </div>
        )
    }
}