import 'babel-polyfill';
import React from 'react';
import ReactDOM from "react-dom";

class SearchBar extends React.Component {
    constructor(props) {
        super(props);
        this.handleButtonClick = this.handleButtonClick.bind(this);
        this.handleKeyPress = this.handleKeyPress.bind(this);
    }

    handleButtonClick() {
      ()=>this.props.pointchage(location);
        this.props.onUserInput(
            this.refs.searchInput.value
        );
    }

    handleKeyPress(e) {
        if (e.key === 'Enter') {
            this.handleButtonClick();
        }
    }


    render() {
        return (
            <div id='search-bar'>
                <input
                    type='text'
                    placeholder='请输入地点名称'
                    ref='searchInput'
                    onKeyPress={this.handleKeyPress}
                />
                <input type='button' value='确定' onClick={this.handleButtonClick} />
            </div>
        );
    }
}


export default SearchBar;
