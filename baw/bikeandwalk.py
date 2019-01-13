from flask import request, session, g, redirect, url_for, abort, \
     render_template, flash, Blueprint
from shotglass2.users.admin import login_required, table_access_required
from shotglass2.takeabeltof.utils import render_markdown_for, printException, handle_request_error, send_static_file
from shotglass2.takeabeltof.date_utils import datetime_as_string
import os

mod = Blueprint('baw',__name__, template_folder='templates/baw', url_prefix='',static_folder='static/baw')

def setExits():
    # g.listURL = url_for('.display')
    # g.editURL = url_for('.edit')
    # g.deleteURL = url_for('.delete')
    g.title = 'Help'

@mod.route('/help/')
@mod.route('/help/<path:path>/')
def help(path=None):
    setExits()
    #import pdb;pdb.set_trace()
    rendered_html = None
    g.title = 'Help'
    g.suppress_page_header = False
    if path:
        path_parts = path.strip('/').split('/')

    if not path or len(path_parts) == 0:
        rendered_html = render_markdown_for('help.md',mod)
    elif path_parts[0].lower() == 'counting':
            return render_template('counting.html')
    elif path_parts[0].lower() == 'count_administration':
        if len(path_parts) > 1:
            return render_template(path)
        return render_template('count_administration/count_administration.html')

    if render_template != None:
        return render_template('index.html',rendered_html=rendered_html,)
    else:
        abort(400)
    
    