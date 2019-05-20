import React, {Component} from 'react';
import Background from '../img/thomas-buhler-301493-unsplash.jpg';

class Welcome extends Component {

    render() {
        return (
            <div style={styles.img}>
                <div className="d-flex justify-content-center" style={styles.text}>
                   <div className="fontBigColor">BLS</div>
                   <div style={styles.textlower}  className="fontSmallColor">Salary</div>
                   <div style={styles.textlower2} className="fontSmallColor">System</div>
                </div>
                <div className="d-flex justify-content-center" style={styles.login}>
                    <div className="btn btn-outline-light btnoverride">Get Started</div>
                </div>
            </div>

        );
    }
}

const styles = {
    img: {
        zIndex: -2,
        backgroundPosition:'center',
        backgroundRepeat: 'no-repeat',
        backgroundSize: 'cover',
        height: '100vh',
        width: 'auto',
        backgroundImage: `url(${Background})`,
    },
    text: {
        clipPath:'polygon(0 0, 50% 0, 100% 48%, 100% 70%, 100% 100%, 50% 100%, 0 50%, 0 25%)',
        background:'rgba(0,0,0,0.4)',
        position:'relative',
        fontSize:'5vh',
        top: '40%',
        width: 'auto',
        color:'white',
        zIndex: 1,

    },
    textlower: {
        marginTop:'5vh',
    },
    textlower2: {
        marginTop:'10vh',
    },
    login:{
        position:'relative',
        margin:'auto',
        top:'50%',
    },
};

export default Welcome;