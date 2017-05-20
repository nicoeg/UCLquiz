import React from 'react'
import axios from 'axios'

export default class QuizResults extends React.Component {
    constructor(props) {
        super(props)

        const correctAnswerCount = props.answers.filter(answer => {
            return props.correctAnswers.find(cAnswer => cAnswer.question_id == answer.question_id).id == answer.answer_id
        }).length

        this.state = {
            correctAnswerCount: correctAnswerCount,
            questionCount: props.questions.length,
            percent: correctAnswerCount / props.questions.length * 100,
            leaderboard: [],
            average_score: null,
            average_time: null,
            current_user: null
        }

        this.renderLeaderboard = this.renderLeaderboard.bind(this)

        this.getResults()
    }

    formatTime(seconds) {
        const minutes = Math.floor(seconds / 60)
        seconds = Math.round(seconds % 60)

        return `${minutes}m ${seconds}s`
    }

    getResults() {
        const quizId = this.props.questions[0].quiz_id

        axios.get('/api/leaderboard/getleaderboard/' + quizId).then(response => {
            this.setState({
                leaderboard: response.data.leaderboard,
                average_score: response.data.average_score,
                average_time: this.formatTime(response.data.average_time),
                current_user: response.data.user_result.user_id
            })
        })
    }

    renderLeaderboard() {
        return this.state.leaderboard.map((result, index) => (
            <div key={result.user_id} className={'highscore' + (result.user_id == this.state.current_user ? ' highlighted' : '')}>
                <div className="place">{index + 1}. {result.name}</div>
                <div className="score">{result.correct_answers_count}/{this.state.questionCount}</div>
            </div>
        ))
    }

    render() {
        return (
            <div className="quiz-container quiz-container--big">
                <div className="tribox-container main-container result">
                    <h1>Resultat</h1>

                    <div className="donut-chart" style={{animationDelay: '-' + this.state.percent + 's'}}>
                        <span>{this.state.correctAnswerCount} ud af {this.state.questionCount} rigtige</span>
                    </div>

                    <h1 className="time"><b>Tid</b> {this.formatTime(this.props.time)}</h1>
                </div>

                <div className="tribox-container main-container result">
                    <h1>Placering</h1>

                    <div className="highscores">
                        {this.renderLeaderboard()}
                    </div>
                </div>

                <div className="tribox-container main-container result">
                    <h1>Gennemsnit</h1>

                    <div className="donut-chart" style={{animationDelay: '-' + this.state.average_score * 100 + 's'}}>
                        <span>{this.state.average_score} ud af {this.state.questionCount} rigtige</span>
                    </div>

                    <h1 className="time"><b>Tid</b> {this.state.average_time}</h1>
                </div>
            </div>
        )
    }
}
