import React from 'react'

export default class VideoAnswer extends React.Component {
    constructor(props) {
        super(props);

        this.state = { selectedAnswer: props.currentAnswer }

        this.selectAnswer = this.selectAnswer.bind(this)
    }

    selectAnswer(id) {
        this.setState({ selectedAnswer: id })

        this.props.selectAnswer(id)
    }

    render() {
        const answers = this.props.answers.map(answer => {
            return (
                <div key={answer.id}
                    onClick={() => this.selectAnswer(answer.id)}
                    className={"answer " + (answer.id == this.state.selectedAnswer ? 'selected' : '')}>
                    {answer.answer}
                </div>
            )
        })

        return (
            <div className="answers videos">
                {answers}
            </div>
        )
    }
}