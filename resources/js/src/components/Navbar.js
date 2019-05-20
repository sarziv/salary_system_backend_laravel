import React from 'react';
import PropTypes from 'prop-types';
import { withStyles, createMuiTheme } from '@material-ui/core/styles';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import MenuIcon from '@material-ui/icons/Menu';
import Logo from '../img/bls-s-s_logo.png'
import purple from '@material-ui/core/colors/purple';

const styles = {
    root: {
        flexGrow: 1,
        background:'#E3E3E3',
        color:'#E3E3E3',
    },
    grow: {
        flexGrow: 1,
    },
    menuButton: {
        marginLeft: -12,
        marginRight: 20,
    },
    img:{
        width:150,
        height:50
    },
};



function ButtonAppBar(props) {
    const { classes } = props;

    return (
        <div className={classes.root}>
            <AppBar position="static" color="primary">
                <Toolbar>
                    <img className={classes.img} src={Logo} alt={Logo}/>
                    <Typography variant="h6" className={classes.grow}>

                    </Typography>
                    <IconButton className={classes.menuButton}  aria-label="Menu">
                        <MenuIcon/>
                    </IconButton>
                </Toolbar>
            </AppBar>
        </div>
    );
}

ButtonAppBar.propTypes = {
    classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(ButtonAppBar);