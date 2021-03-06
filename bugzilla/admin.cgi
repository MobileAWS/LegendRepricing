#!/usr/bin/perl -wT
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
#
# This Source Code Form is "Incompatible With Secondary Licenses", as
# defined by the Mozilla Public License, v. 2.0.

use strict;

use lib qw(. lib);

use Bugzilla;
use Bugzilla::Constants;
use Bugzilla::Error;

my $cgi = Bugzilla->cgi;
my $template = Bugzilla->template;
my $user = Bugzilla->login(LOGIN_REQUIRED);

print $cgi->header();

$user->in_group('admin')
  || $user->in_group('tweakparams')
  || $user->in_group('editusers')
  || $user->can_bless
  || (Bugzilla->params->{'useclassification'} && $user->in_group('editclassifications'))
  || $user->in_group('editcomponents')
  || scalar(@{$user->get_products_by_permission('editcomponents')})
  || $user->in_group('creategroups')
  || $user->in_group('editkeywords')
  || $user->in_group('bz_canusewhines')
  || ThrowUserError('auth_failure', {action => 'access', object => 'administrative_pages'});

$template->process('admin/admin.html.tmpl')
  || ThrowTemplateError($template->error());
