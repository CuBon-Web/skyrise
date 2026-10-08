import {HTTP} from '../../core/plugins/http'

export const listEvent = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/website/event/list', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};
export const saveEvent = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/website/event/save', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};
export const detailEvent = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/website/event/edit/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};
export const deleteEvent = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/website/event/delete/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};
