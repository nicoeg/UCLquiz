import React, { Component } from 'react'

export default class Sidebar extends Component {
	constructor(props) {
		super(props)

		this.handleChooseClass = this.handleChooseClass.bind(this)
	}

	handleChooseClass() {
		this.props.handleChooseClass()
	}

	percent() {
		return this.props.averageAnswerRate ? this.props.questionsLength / this.props.averageAnswerRate * 10 : 100;
	}

	render() {
		return (
			<div className="sidebar" style={{ marginTop: '5px' }}>
				<div className="sidebar__buttons">
					<a href={window.settings.baseUrl + 'teacher'} style={{textDecoration: 'none'}} className="button button--primary">Tilbage</a>

					<span className="button button--primary" onClick={this.handleChooseClass}>Vælg klasse</span>
				</div>

				<div className="sidebar__block">
					<h1 className="sidebar__heading">Gennemsnits svarrate</h1>

					<div className="donut-chart" style={{transform: 'scale(.8)', animationDelay: '-' + this.percent() + 's'}}>
                        <span>{this.props.averageAnswerRate} ud af {this.props.questionsLength} rigtige</span>
                    </div>
				</div>

				<div className="sidebar__block">
					<h1 className="sidebar__heading">Gennemsnits tid</h1>

					<h1 className="sidebar__heading sidebar__heading--primary">{this.props.averageTime}</h1>
				</div>

				<div className="sidebar__block">
					<h1 className="sidebar__heading">Bedste tid</h1>

					<h1 className="sidebar__heading sidebar__heading--primary">{this.props.bestTime}</h1>
				</div>
			</div>
		)
	}
}
