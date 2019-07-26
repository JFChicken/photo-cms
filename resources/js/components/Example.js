import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Example extends Component {
    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                <h1>THIS IS NEW</h1>
                        <div className="card">
                            <div className="card-header">MAKE THIS UPDATE</div>
                            <div className="card-body">This will contain a set of sub components that willmake the site look really really good!!</div>
                        </div>

                </div>
            </div>
        );
    }
}

if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}
