import 'package:sngpbad_dashboard/models/user_model.dart';

final List<UserModel> testUsers = [
  UserModel(
    email: 'bad@test.ci',
    password: '123Bad',
    name: 'Jean Dupont',
    role: UserRole.badRepresentative,
  ),
  UserModel(
    email: 'ministere@test.ci',
    password: '123Min',
    name: 'Moussa Traoré',
    role: UserRole.ministryOfTutelle,
  ),
  UserModel(
    email: 'direction@test.ci',
    password: '123Dir',
    name: 'Awa Koné',
    role: UserRole.nationalDirection,
  ),
  UserModel(
    email: 'audit@test.ci',
    password: '123Aud',
    name: 'Cabinet Audit Pro',
    role: UserRole.externalAuditor,
  ),
  UserModel(
    email: 'entreprise@test.ci',
    password: '123Pre',
    name: 'BTP Construction CI',
    role: UserRole.prestataire,
  ),
];