import React,{useEffect} from 'react';
import './Connected.css';
import shave from 'shave';

export default function Connected(props) {
    const {users,handleData} = props;
    useEffect(() => {
         shave('.connected-name', 30);
    });

    return (
        <div className="scroll-horizontal">

            <div className="connected-bigtitle">Connectés ({users.length})</div>
            <div className="inline-container">
               {[users.map(user =>{ 
                   return <div class="inline-item" onClick={()=>handleData(user)}>
                        <div className="connected-profile">
                            <img className="connected-photo" src={user.photo} alt="connected" />
                            <span className="isconnected-state"></span>
                        </div>
                        <div className="connected-info">
                            <h1 className="connected-name">{ user.name }</h1>
                            <p className="connected-statut">Connecté</p>
                        </div>
                    </div>
                    })
                ]
            }
            </div>
        </div>
    );
}