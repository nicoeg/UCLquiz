import React from 'react'

export default class QuizResults extends React.Component {
    constructor(props) {
        super(props)

        const correctAnswerCount = props.answers.filter(answer => {
            return props.correctAnswers.find(cAnswer => cAnswer.question_id == answer.question_id).id == answer.answer_id
        }).length

        this.state = {
            correctAnswerCount: correctAnswerCount,
            questionCount: props.questions.length,
            percent: correctAnswerCount / props.questions.length * 100
        }
    }

    render() {
        return (
            <div className="quiz-container quiz-container--big">
                <div className="tribox-container main-container result">
                    <h1>Resultat</h1>

                    <div className="donut-chart" style={{animationDelay: '-' + this.state.percent + 's'}}>
                        <span>{this.state.correctAnswerCount} ud af {this.state.questionCount} rigtige</span>
                    </div>

                    <h1 className="time"><b>Tid</b> 5m 03s</h1>
                </div>

                <div className="tribox-container main-container result">
                    <h1>Placering</h1>

                    <div className="highscores">
                        <div className="highscore">
                            <div className="place">1. Sofie Jensen</div>
                            <div className="score">5/5</div>
                        </div>
                        <div className="highscore">
                            <div className="place">2. Sofie Nielsen</div>
                            <div className="score">5/5</div>
                        </div>
                        <div className="highscore">
                            <div className="place">3. Sofie Hansen</div>
                            <div className="score">5/5</div>
                        </div>
                        <div className="highscore">
                            <div className="place">4. Sofie Olesen</div>
                            <div className="score">5/5</div>
                        </div>
                        <div className="highscore">
                            <div className="place">4. Sofie Mikkelsen</div>
                            <div className="score">5/5</div>
                        </div>
                        <div className="highscore highlighted">
                            <div className="place">8. Dig</div>
                            <div className="score">4/5</div>
                        </div>
                    </div>
                </div>

                <div className="tribox-container main-container result">
                    <h1>Gennemsnit</h1>

                    <div className="donut-chart" style={{animationDelay: '-60s'}}>
                        <span>3 ud af 5 rigtige</span>
                    </div>

                    <h1 className="time"><b>Tid</b> 5m 47s</h1>
                </div>
            </div>
        )
    }
}
