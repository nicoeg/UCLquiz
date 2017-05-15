import React, {Component} from 'react'

const blockName = 'create-quiz-header'

export default class Header extends Component {
	constructor(props) {
		super(props)

		this.renderSteps = this.renderSteps.bind(this)
	}

	renderSteps() {
		return this.props.steps.map((step, index) => (
			<div key={index} className={'steps__section' + (index <= this.props.active ? ' steps__section--active' : '')}>
				{index > 0 && 
					<div  className="steps__indicator"></div>
				}
				<div className="steps__step" onClick={() => this.props.setStep(index)}>{index+1}</div>
			</div>
		))
	}

	render() {
		return (
			<div className={blockName + ' quiz-container quiz-container--big'} style={{minHeight: '0'}}>
				<span className="button button--primary">Se quiz</span>

				<div className="steps">
					{this.renderSteps()}
				</div>

				<div className={blockName + '__next-button button button--primary'}>Næste</div>
			</div>
		)
	}
}
