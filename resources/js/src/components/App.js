import React, {Component} from 'react';
import Navbar from '../components/Navbar';

import {MuiThemeProvider, createMuiTheme} from "@material-ui/core";
import Welcome from "./Welcome";

const theme = createMuiTheme({
    palette: {
        primary: {
            main:  '#E3E3E3',
        },
        secondary: {
            main: '#000000',
        }
    },
    typography: {
        useNextVariants: true,

    },
});

class App extends Component {

    render() {
        return (
            <MuiThemeProvider theme={theme}>
                    <Navbar/>
                    <Welcome/>
            </MuiThemeProvider>
        );
    }
}

export default App;