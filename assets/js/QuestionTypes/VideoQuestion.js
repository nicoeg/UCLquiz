import React from 'react'
import YouTube from 'react-youtube'

export default class VideoQuestion extends React.Component {
    constructor(props) {
        super(props);

        this.state = { selectedAnswer: props.currentAnswer, videos: {} }

        this.selectAnswer = this.selectAnswer.bind(this)
    }

    selectAnswer(id) {
        if (this.props.readOnly) return

        this.setState({ selectedAnswer: id })

        this.props.selectAnswer(id)
    }

    videoReady(answer, event) {
        let videos = this.state.videos
        videos[answer.id] = event.target

        this.setState({ videos })
    }

    render() {
        const videoOptions = {
            width: '100%',
            height: 'calc(100% - 50)',
            playerVars: {
                controls: 0,
                autoplay: 0,
                modestbranding: 0,
                rel: 0,
                showinfo: 1
            }
        }

        const answers = this.props.answers.map(answer => {
            return (
                <div key={answer.id} className={"answer " + (answer.id == this.state.selectedAnswer ? 'selected' : '')}>
                    <YouTube videoId={answer.answer} opts={videoOptions} onReady={(event) => this.videoReady(answer, event)}/>

                    <div onClick={() => this.selectAnswer(answer.id)} className="button">
                        { (answer.id == this.state.selectedAnswer ? 'Valgt' : 'Vælg') }
                    </div>
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