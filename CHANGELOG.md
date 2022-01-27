# Changelog

### [1.3.1](https://www.github.com/fluid-project/hearth/compare/v1.3.0...v1.3.1) (2022-01-27)


### Bug Fixes

* handle validation of fields with array names (fix [#91](https://www.github.com/fluid-project/hearth/issues/91)) ([#92](https://www.github.com/fluid-project/hearth/issues/92)) ([aa746ab](https://www.github.com/fluid-project/hearth/commit/aa746ab42a360cae0ac09cfd157a0ccc5fbac66b))

## [1.3.0](https://www.github.com/fluid-project/hearth/compare/v1.2.0...v1.3.0) (2021-12-03)


### Features

* add Checkbox and Checkboxes components (resolves [#83](https://www.github.com/fluid-project/hearth/issues/83)) ([#86](https://www.github.com/fluid-project/hearth/issues/86)) ([1fbe4a2](https://www.github.com/fluid-project/hearth/commit/1fbe4a2f0d96b42fc2d29ec9e5c228c56f1156de))


### Bug Fixes

* handle errors properly for date input (resolves [#84](https://www.github.com/fluid-project/hearth/issues/84)) ([#85](https://www.github.com/fluid-project/hearth/issues/85)) ([43a6dd3](https://www.github.com/fluid-project/hearth/commit/43a6dd34c04ae6c1625ce27e36b1bf0caa4e415c))
* prevent deletion of user if they are sole organization admin ([#77](https://www.github.com/fluid-project/hearth/issues/77)) ([af81e3e](https://www.github.com/fluid-project/hearth/commit/af81e3e4839459fcce2777b962e2d3216545e5c6))
* properly handle empty input when adding locales (resolves [#74](https://www.github.com/fluid-project/hearth/issues/74)) ([#76](https://www.github.com/fluid-project/hearth/issues/76)) ([c10ed1f](https://www.github.com/fluid-project/hearth/commit/c10ed1fd9658ebd448ee026fd36681d4a6a2b2f9))


### Miscellaneous Chores

* **l10n:** update translations ([#80](https://www.github.com/fluid-project/hearth/issues/80)) ([3a167f8](https://www.github.com/fluid-project/hearth/commit/3a167f81690347fe988c94585774e344ce6625ea))

## [1.2.0](https://www.github.com/fluid-project/hearth/compare/v1.1.0...v1.2.0) (2021-09-07)


### Features

* add hint association and attribute passthrough for radio buttons ([#72](https://www.github.com/fluid-project/hearth/issues/72)) ([848853d](https://www.github.com/fluid-project/hearth/commit/848853d96752ddb56f1616c6d35c8496c731d757))


### Bug Fixes

* call locales helper in global namespace ([#66](https://www.github.com/fluid-project/hearth/issues/66)) ([b313221](https://www.github.com/fluid-project/hearth/commit/b31322122b1f579bb67c8e8de185ef51b57fafbd))
* don't trigger date validation unless all fields are populated ([#67](https://www.github.com/fluid-project/hearth/issues/67)) ([ce8b6ce](https://www.github.com/fluid-project/hearth/commit/ce8b6cee5503cd10898074a41c6fe83cbf018866)), closes [#63](https://www.github.com/fluid-project/hearth/issues/63)
* move date input hint position above fields ([#71](https://www.github.com/fluid-project/hearth/issues/71)) ([73ff22f](https://www.github.com/fluid-project/hearth/commit/73ff22fb5e94bb053536c9c7bb398565b24d4be8))

## [1.1.0](https://www.github.com/fluid-project/hearth/compare/v1.0.0...v1.1.0) (2021-08-31)


### Features

* accept optional id reference for hinted inputs (fix [#50](https://www.github.com/fluid-project/hearth/issues/50)) ([#59](https://www.github.com/fluid-project/hearth/issues/59)) ([90f9e54](https://www.github.com/fluid-project/hearth/commit/90f9e54db6872ebe1e847d4b425f9ed8819ce252))
* add slot support to hearth-error component ([892fbb2](https://www.github.com/fluid-project/hearth/commit/892fbb2adc7aad9df0c0337a43b104d4a2de3bb1))
* implement date input (resolves [#58](https://www.github.com/fluid-project/hearth/issues/58)) ([#60](https://www.github.com/fluid-project/hearth/issues/60)) ([3e520a5](https://www.github.com/fluid-project/hearth/commit/3e520a53a5bf765e3923af8824963d39a2b28db8))
* replace validation-error component with hearth-error ([#56](https://www.github.com/fluid-project/hearth/issues/56)) ([892fbb2](https://www.github.com/fluid-project/hearth/commit/892fbb2adc7aad9df0c0337a43b104d4a2de3bb1))


### Bug Fixes

* add correct return types for resource controller ([#52](https://www.github.com/fluid-project/hearth/issues/52)) ([5d07a48](https://www.github.com/fluid-project/hearth/commit/5d07a48e7308634eceb240f631f130ed5ca3d285))
* call localization helpers from global namespace ([#54](https://www.github.com/fluid-project/hearth/issues/54)) ([9ba7d45](https://www.github.com/fluid-project/hearth/commit/9ba7d45ee6bef7337f8c21579bd419bc0f8585d5))
* change fallback application name to Hearth, add rel='home' to brand ([#55](https://www.github.com/fluid-project/hearth/issues/55)) ([f4b3228](https://www.github.com/fluid-project/hearth/commit/f4b3228a0c5409d37a49144cde028ea5c6a9060c))

## 1.0.0 (2021-08-26)


### Features

* add config and factories to support organizations ([fe65583](https://www.github.com/fluid-project/hearth/commit/fe6558348a9f8575bf28025015539c61daf8b143))
* add controllers, views and routes ([a4453c6](https://www.github.com/fluid-project/hearth/commit/a4453c6555e2cef89badc4acecbc4b3b107be42c))
* add full attribute support to locale-select component ([fcae807](https://www.github.com/fluid-project/hearth/commit/fcae8073c3291a538864b56b2cd4e153b635c9f1))
* add get_locale_name() helper ([fcae807](https://www.github.com/fluid-project/hearth/commit/fcae8073c3291a538864b56b2cd4e153b635c9f1))
* add get_region_codes() helper and fix some localizations ([46c8480](https://www.github.com/fluid-project/hearth/commit/46c8480abbaa37f81fc090a6350443ed0ff39e56))
* add get_region_name() helper and switch to ISO 3166-2 codes for regions ([db61e41](https://www.github.com/fluid-project/hearth/commit/db61e41e1185a2fd5f245f28b629a8a9948fbe79))
* add interactive locale selection during hearth:install ([7926352](https://www.github.com/fluid-project/hearth/commit/7926352b36f979891b31c103ef374ed2b665b202))
* add migrations for organizations, memberships, and invitations ([0b98778](https://www.github.com/fluid-project/hearth/commit/0b98778b5c8b91c87ad6f5d65ed6c0d4ff608831))
* add RequirePassword middleware with localization support ([d38328d](https://www.github.com/fluid-project/hearth/commit/d38328ddc6a6e4cd72230afecc216e1213adff5c))
* add resources and resource tests (resolves [#7](https://www.github.com/fluid-project/hearth/issues/7), resolves [#8](https://www.github.com/fluid-project/hearth/issues/8)) ([#44](https://www.github.com/fluid-project/hearth/issues/44)) ([fcae807](https://www.github.com/fluid-project/hearth/commit/fcae8073c3291a538864b56b2cd4e153b635c9f1))
* add status messages ([8af0863](https://www.github.com/fluid-project/hearth/commit/8af086356cfd1e8b229dd885a85f59e1b6401dcd))
* add strings for two-factor challenge, handle recovery codes ([b32d872](https://www.github.com/fluid-project/hearth/commit/b32d872a8851d23e9f6a5e4d40faca96741472ff))
* add stubs for Organization, Membership and Invitation ([3054e8f](https://www.github.com/fluid-project/hearth/commit/3054e8f7aa69fafff9b10e60b5d8437155577d7f))
* add user model ([#1](https://www.github.com/fluid-project/hearth/issues/1)) ([86a5665](https://www.github.com/fluid-project/hearth/commit/86a5665d90db44c1e327a8fd73774599a42524dd))
* allow regeneration of two-factor codes ([0309e35](https://www.github.com/fluid-project/hearth/commit/0309e35642fcc52d41c0c046748eb3e6d4280709))
* close dropdown on esc keyup ([a1209ac](https://www.github.com/fluid-project/hearth/commit/a1209ac18e4bd8b4250df186ea01ab5baa0cab60))
* conditionally register organization routes ([55a8349](https://www.github.com/fluid-project/hearth/commit/55a8349abc03f1b85a104a0c9ed0c04b71d7303a))
* create get_regions() helper ([53b8879](https://www.github.com/fluid-project/hearth/commit/53b88795539e3a24844baf0f6bea336288e5a9d9))
* custom error message, handle errors properly ([149545e](https://www.github.com/fluid-project/hearth/commit/149545e1c4c9d4c5b4c18e91119b1d5a3ce4d76f))
* custom RedirectIfTwoFactorAuthenticable action ([86bf999](https://www.github.com/fluid-project/hearth/commit/86bf999a6dd987ed72cf8a76076076414962b51e))
* display recovery codes properly ([b8ba12c](https://www.github.com/fluid-project/hearth/commit/b8ba12c2afd2ee3c0c698baf5ffbdbc46b96d463))
* fix modal display ([38bcefe](https://www.github.com/fluid-project/hearth/commit/38bcefe9b3ee2b71208182eb3762d4d6c727896c))
* improve error handling for invitation flow (resolves [#28](https://www.github.com/fluid-project/hearth/issues/28)) ([#41](https://www.github.com/fluid-project/hearth/issues/41)) ([ae06929](https://www.github.com/fluid-project/hearth/commit/ae069298b4dc973d95f9b22269d1525dca3d698a))
* improve form components and capabilities ([#35](https://www.github.com/fluid-project/hearth/issues/35)) ([7b840ca](https://www.github.com/fluid-project/hearth/commit/7b840ca577ac21ad8d64496e930e98fc8b33f7b1))
* inline password confirmation ([ea73f0a](https://www.github.com/fluid-project/hearth/commit/ea73f0a4c67ee244ade944969b42e87e617e6880))
* load default locale from config/app.php in register view ([b47565f](https://www.github.com/fluid-project/hearth/commit/b47565f1e1841e431d207a91ad2cf5ddef23726d))
* make locale selection an explicit yes/no choice (resolves [#25](https://www.github.com/fluid-project/hearth/issues/25)) ([#40](https://www.github.com/fluid-project/hearth/issues/40)) ([8e41b62](https://www.github.com/fluid-project/hearth/commit/8e41b624a51ff29c8dc561b78ad0d2c8f7daa795))
* make password confirmation component generic (fix [#23](https://www.github.com/fluid-project/hearth/issues/23)) ([a05dacf](https://www.github.com/fluid-project/hearth/commit/a05dacff6f07d6486c948c6a86acc9e53aefb6ea))
* modal for password confirmation ([bb325be](https://www.github.com/fluid-project/hearth/commit/bb325be43e431a340220023d520e0547c396ed24))
* provide localized default strings ([107acbb](https://www.github.com/fluid-project/hearth/commit/107acbb4f8af229098c3ff3ce4086a1f5a92c5dd))
* publish Hearth config ([966ab54](https://www.github.com/fluid-project/hearth/commit/966ab549f71be8e664091ea1bc7b21a979b83510))
* rough two-factor implementation ([fe3a3a7](https://www.github.com/fluid-project/hearth/commit/fe3a3a70f7afa2617399b48bbf6bd9f969af1dfd))
* split routes by feature ([4b1f2d7](https://www.github.com/fluid-project/hearth/commit/4b1f2d7b6672107370755964494d18abc9a5d27e))
* two-factor challenge ([4a23da7](https://www.github.com/fluid-project/hearth/commit/4a23da75b451f0de371303d83f4e6ebbed1bd6f7))


### Bug Fixes

* add Auth facade to AcceptInvitation action ([971b07d](https://www.github.com/fluid-project/hearth/commit/971b07d94b575e72ab2fb95a7d5ed26028667a59))
* add blank entry when retrieving list of regions ([df8a501](https://www.github.com/fluid-project/hearth/commit/df8a501437f8590243b31aaaa8f7f667f2bdae81))
* add classes to service provider ([0767ab8](https://www.github.com/fluid-project/hearth/commit/0767ab816b4b672653a4ef86af730bd75c1d4c1c))
* add error if user attempting to accept invitation isn't invitee ([e81cf3c](https://www.github.com/fluid-project/hearth/commit/e81cf3c8f3a4eefd96458e67144ac3973d3dce0c))
* add flag to skip interactive install steps for ci ([7d5aa42](https://www.github.com/fluid-project/hearth/commit/7d5aa42e95e166067a6d095dba4267bbdd2bae76))
* add fr to default locales ([bfc2744](https://www.github.com/fluid-project/hearth/commit/bfc274484a6a18501b25663ff0325ad30fbaa894))
* add id and name to the region select ([efab24a](https://www.github.com/fluid-project/hearth/commit/efab24aca311c062f4d9c4fe57306cd31f24cd52))
* add locale prompt ([bb0d016](https://www.github.com/fluid-project/hearth/commit/bb0d016c506d67aba92a04558f9a9716c7c66c45))
* add region options ([c683f78](https://www.github.com/fluid-project/hearth/commit/c683f7829bdcfde476a089d74f21a1544702f1c5))
* add return types to improve static analysis ([178bf2b](https://www.github.com/fluid-project/hearth/commit/178bf2b3e5fab4a0cbf69ac74bf27b174def586b))
* adjust PHP requirements ([8498453](https://www.github.com/fluid-project/hearth/commit/8498453d00ab237ec179900787c34975e210603f))
* apply code styling rules ([448eb97](https://www.github.com/fluid-project/hearth/commit/448eb97c41c9d53b054693f7ecb50ef3b5124357))
* apply code styling rules ([36bfc92](https://www.github.com/fluid-project/hearth/commit/36bfc923137e7972ef30caccba0da459c080d298))
* apply code styling rules ([5e3ae2d](https://www.github.com/fluid-project/hearth/commit/5e3ae2d1607dcb9c3219407080eb947c9c12fc48))
* apply code styling rules ([512f0e0](https://www.github.com/fluid-project/hearth/commit/512f0e0edf2e9e17e9e2ca755995fd42e5185292))
* apply code styling rules ([33c09e0](https://www.github.com/fluid-project/hearth/commit/33c09e0e446be3b177fb8a5fef6ba12564e5cce5))
* apply code styling rules ([0a3ef4a](https://www.github.com/fluid-project/hearth/commit/0a3ef4a7c08ba1d926dad3ac8bca22ac276caa4c))
* apply code styling rules ([f4fbff6](https://www.github.com/fluid-project/hearth/commit/f4fbff60bb5a97f6d6428c3749bf7471b777269b))
* apply code styling rules ([65e856c](https://www.github.com/fluid-project/hearth/commit/65e856cae4a58fccff284e47d05a89c4ca539359))
* autoload helpers properly ([2a414fe](https://www.github.com/fluid-project/hearth/commit/2a414fec736682e25228d4c54f1504d6a216a423))
* bad method in admin template ([9497d56](https://www.github.com/fluid-project/hearth/commit/9497d568793b9dda546f8c615c95dd290614c57b))
* capitalize locale-select locales ([fcae807](https://www.github.com/fluid-project/hearth/commit/fcae8073c3291a538864b56b2cd4e153b635c9f1))
* check for no-interaction ([19c651b](https://www.github.com/fluid-project/hearth/commit/19c651b48564964480939bc8835ba6842c26883a))
* clean up config file ([0519e0d](https://www.github.com/fluid-project/hearth/commit/0519e0d37adf65c7c7423c0458d93bb0f0a08c80))
* conditional check for two-factor ([53be62f](https://www.github.com/fluid-project/hearth/commit/53be62f5fa041fc08ab80f139ed7776e16189067))
* copy failed two-factor login response ([b08e22c](https://www.github.com/fluid-project/hearth/commit/b08e22caa4dfa62f540fa7f4820ba84a48c0fb36))
* copy model stubs on install ([b6b05c6](https://www.github.com/fluid-project/hearth/commit/b6b05c60f6047c28543735b37b7dba9cd4bd6ade))
* correct namespace ([2083e92](https://www.github.com/fluid-project/hearth/commit/2083e9266a182fb49e6224a57db50c75b0c33e4a))
* display recovery codes when regenerated ([1b1b33b](https://www.github.com/fluid-project/hearth/commit/1b1b33b71da6d5b0d7cb1cedcc2a940b8058477f))
* enable two-factor by modifying config ([95c309b](https://www.github.com/fluid-project/hearth/commit/95c309b57ddc1879286838ca1a8e91da0afda085))
* enable two-factor by modifying config ([a9b6476](https://www.github.com/fluid-project/hearth/commit/a9b6476ecc7ab04ff353ca0c34176595f21b7434))
* ensure default messages are loaded for password confirmation ([77e1e2c](https://www.github.com/fluid-project/hearth/commit/77e1e2ca26d21cfe097df585816e469ebbe12c8d))
* ensure that only invited user can accept invitation ([97e63be](https://www.github.com/fluid-project/hearth/commit/97e63be331b0bb87d38cda1c340010ec97abe720))
* improve message for failed invitation accept attempt ([e926d2a](https://www.github.com/fluid-project/hearth/commit/e926d2af3f569867c6b4e32c5853465f76327413))
* install RequirePassword middleware ([f2b5b65](https://www.github.com/fluid-project/hearth/commit/f2b5b6599a9ffb5f5ce7b33bfa105b8c643e34cd))
* localized route in two-factor challenge view ([2aec4f7](https://www.github.com/fluid-project/hearth/commit/2aec4f7dcfde905ffc3749bef53f823418860618))
* migration publishing ([02756c8](https://www.github.com/fluid-project/hearth/commit/02756c861468815484b0e1d5b89c51ad2acded59))
* move invitation template into proper location ([229c8ae](https://www.github.com/fluid-project/hearth/commit/229c8ae630a38561d015e5b6a04247391c3a0ba0))
* move invitation template into proper location ([1174f62](https://www.github.com/fluid-project/hearth/commit/1174f6241e311dd4778c24e629c7b1a26da30f51))
* namespace components ([2bb0b05](https://www.github.com/fluid-project/hearth/commit/2bb0b052a306331e0af454da66be49caa11eb86a))
* namespace more components ([4eba5dd](https://www.github.com/fluid-project/hearth/commit/4eba5dde13d77e225004d93bedf2ef746d262d1d))
* normalize locale endonyms (resolves [#26](https://www.github.com/fluid-project/hearth/issues/26)) ([#39](https://www.github.com/fluid-project/hearth/issues/39)) ([470783b](https://www.github.com/fluid-project/hearth/commit/470783bc0a8e4d58549f20730a121702d0f16568))
* only add RedirectToPreferredLocale middleware if it hasn't been added yet ([bf0137b](https://www.github.com/fluid-project/hearth/commit/bf0137b7e57f9202618414e245a3d4786aa17387))
* prevent function from being namespaced ([25e234e](https://www.github.com/fluid-project/hearth/commit/25e234e9ebfd8fae23804f413e8fa8f3da2fda95))
* proper class name ([56da49a](https://www.github.com/fluid-project/hearth/commit/56da49aa65e66b3a395a9819f097d138147325b4))
* proper class name ([ee37849](https://www.github.com/fluid-project/hearth/commit/ee37849f494cf87a1ede219e382891d24988da4b))
* proper route ([c12760b](https://www.github.com/fluid-project/hearth/commit/c12760b4e5ece6590be18510e6d8affbc71e7e7b))
* properly copy tests ([7f068a4](https://www.github.com/fluid-project/hearth/commit/7f068a4dec33db8231694806f8d58438c4d13510))
* publishing issue ([6811ec4](https://www.github.com/fluid-project/hearth/commit/6811ec4e726824f3e6977c1be8754fcd99f9b042))
* put prompt where it belongs ([0cab58d](https://www.github.com/fluid-project/hearth/commit/0cab58d6c7b6fc279d7822560b9380d0f3a50373))
* region validation rule ([9e213e1](https://www.github.com/fluid-project/hearth/commit/9e213e1af5af94279804a557a85dc92b598e8891))
* remove 'custom-message' string ([c8803fc](https://www.github.com/fluid-project/hearth/commit/c8803fc920725fe35d730628384b3e45c4b465e2))
* remove debugging code ([9485696](https://www.github.com/fluid-project/hearth/commit/9485696145a4001c16ee1ed5fd74ac464955ba46))
* remove leftover code ([ffe0568](https://www.github.com/fluid-project/hearth/commit/ffe05686683522c2d32ad9cde9a1bf3835ef855d))
* remove missing config file from command ([387e2da](https://www.github.com/fluid-project/hearth/commit/387e2dacd760073b93af6341df60893ce5d641ba))
* remove unused two-factor contract ([69e7316](https://www.github.com/fluid-project/hearth/commit/69e7316d5e02028bbc3e756c9057faa790926bae))
* some PHP coding standards fixes ([6e3ef54](https://www.github.com/fluid-project/hearth/commit/6e3ef54c6be50c8dca22cb0a55f417c284723fcf))
* update config references ([cd12d31](https://www.github.com/fluid-project/hearth/commit/cd12d3198e8f439a2e50ed7450bf401144d18bd9))
* update config references ([2d31498](https://www.github.com/fluid-project/hearth/commit/2d31498ef497a07da817e73254f8ed3f5a25a031))
* update get_region_name() to match method in commerceguys/addressing ([573a1d6](https://www.github.com/fluid-project/hearth/commit/573a1d6d00ac4c38700d2e4c501605a0e3a10329))
* update strings, register in service provider ([3faef75](https://www.github.com/fluid-project/hearth/commit/3faef7583f25ad3208afdfb9e0c8601f61ff9ed7))
* update variable in get_region_name() ([3d5b82c](https://www.github.com/fluid-project/hearth/commit/3d5b82cc09cca8ff54316acbb85f16a4a65601c1))
* use built-in no-interaction flag ([9cac9ee](https://www.github.com/fluid-project/hearth/commit/9cac9eec87ea817a2f50a1a62a620ae07b480094))
* use generic select for region selection, add cascade delete support ([3c85c97](https://www.github.com/fluid-project/hearth/commit/3c85c977bab5c0af8003f01db0b7221beaf3bb9b))
* use Hearth strings where possible ([5158325](https://www.github.com/fluid-project/hearth/commit/5158325cf2d45027db7a18d1fb2552fbf9b990d8))
* use proper field types ([8690648](https://www.github.com/fluid-project/hearth/commit/8690648635b30226305816bc27469e65d5b4110e))
