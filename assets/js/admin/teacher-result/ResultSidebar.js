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
		return 40;
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
                        <span>2 ud af 5 rigtige</span>
                    </div>
				</div>

				<div className="sidebar__block">
					<h1 className="sidebar__heading">Gennemsnits tid</h1>

					<h1 className="sidebar__heading sidebar__heading--primary">8 min 5 sek</h1>
				</div>

				<div className="sidebar__block">
					<h1 className="sidebar__heading">Bedste tid</h1>

					<h1 className="sidebar__heading sidebar__heading--primary">8 min 5 sek</h1>
				</div>
			</div>
		)
	}
}
