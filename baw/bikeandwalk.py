from flask import request, session, g, redirect, url_for, abort, \
     render_template, flash, Blueprint
from jinja2 import TemplateNotFound
from shotglass2.users.admin import login_required, table_access_required
from shotglass2.takeabeltof.utils import render_markdown_for, printException, handle_request_error, send_static_file
from shotglass2.takeabeltof.date_utils import datetime_as_string
import os

mod = Blueprint('baw',__name__, template_folder='templates/baw', url_prefix='',static_folder='static/baw')

def setExits():
    # g.listURL = url_for('.display')
    # g.editURL = url_for('.edit')
    # g.deleteURL = url_for('.delete')
    g.title = 'Home'
    
# @mod.route('/')
# def help(path=None):
#     setExits()
#     rendered_html = None
#     g.title = 'Home'
#     g.suppress_page_header = True
#     rendered_html = render_markdown_for('inext.md',mod)
#     return render_template('index.html',rendered_html=rendered_html,)
#

@mod.route('/help/')
@mod.route('/help/<path:path>/')
@mod.route('/help/<path:path>')
def help(path=None):
    setExits()
    #import pdb;pdb.set_trace()
    rendered_html = None
    g.title = 'Help'
    g.suppress_page_header = False
    if path:
        path_parts = path.strip('/').split('/')

    try:
        if not path or len(path_parts) == 0:
            rendered_html = render_markdown_for('help.md',mod)
        elif path_parts[0].lower() == 'counting':
                return render_template('counting.html')
        elif path_parts[0].lower() == 'count_administration':
            if len(path_parts) > 1:
                return render_template(path)
            return render_template('count_administration/count_administration.html')

    except TemplateNotFound:
    # Old crawler data looks for help files differently
        return redirect('/help/' + path + '/' + path_parts[-1] + '.html')
        
    if rendered_html!= None:
        return render_template('index.html',rendered_html=rendered_html,)
    else:
        return abort(404)
    
@mod.route('/links/')
def links():
    setExits()
    #import pdb;pdb.set_trace()
    rendered_html = None
    g.title = 'Links'
    g.suppress_page_header = False
    rendered_html = render_markdown_for('links.md',mod)
    if render_template != None:
        return render_template('index.html',rendered_html=rendered_html,)
    else:
        return abort(404)
   
   
@mod.route('/docs/')
@mod.route('/docs/<path:path>/')
def docs(path=None):
    setExits()
    #import pdb;pdb.set_trace()
    rendered_html = None
    g.title = 'Docs'
    g.suppress_page_header = False
    if path:
        path_parts = path.strip('/').split('/')

    if not path or len(path_parts) == 0:
        rendered_html = render_markdown_for('docs.md',mod)
    elif path_parts[0].lower() == 'forms':
        g.title = "Forms"
        rendered_html = render_markdown_for('forms.md',mod)
    elif path_parts[0].lower() == 'usecase':
        g.title = "Bike And Walk Use Case"
        rendered_html = render_markdown_for('usecase.md',mod)
    elif path_parts[0].lower() == 'api':
        g.title = "Pages & API end points"
        rendered_html = render_markdown_for('api.md',mod)
    elif path_parts[0].lower() == 'data':
        g.title = "Data Dictionary"
        rendered_html = render_markdown_for('data.md',mod,escape=False) #False to preserve html
    elif path_parts[0].lower() == 'delriotrail':
        g.title = "Del Rio Trail Bike Count Project"
        rendered_html = render_markdown_for('delRioTrail.md',mod,escape=False) #False to preserve html

    if rendered_html != None:
        return render_template('index.html',rendered_html=rendered_html,)
    else:
        # Try to find it in shotglass docs
        from shotglass2.www.views import home
        return home.docs(path)
        
    return abort(404)
